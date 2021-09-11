<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/api/reset-password', methods: ['POST'])]
class ApiResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;


    public function __construct(private ResetPasswordHelperInterface $resetPasswordHelper, private ValidatorInterface $validator)
    {
    }

    /**
     * Display & process form to request a password reset.
     */
    #[Route('', name: 'api_forgot_password_request')]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $jsonRaw = $request->getContent();
        $jsonData = json_decode($jsonRaw);
        $errors = $this->validator->validate($jsonData->email, [
            new Email(['message' => 'Cet email n\'est pas valide']),
            new NotBlank(['message' => 'Entrez un email'])
        ]);

        if (count($errors) === 0) {
            $this->processSendingPasswordResetEmail(
                $jsonData->email,
                $mailer
            );
            return $this->json([
                'message' => 'un email vous a été envoyé si votre compte existe'
            ], Response::HTTP_OK);
        }
        return $this->json([
            $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     */
    #[Route('/reset/{token}', name: 'api_reset_password')]
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, string $token = null): Response
    {

        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {

            return $this->json([
                'message' => sprintf(
                    'There was a problem validating your reset request - %s',
                    $e->getReason()
                )
            ], Response::HTTP_BAD_REQUEST);
        }

        // The token is valid; allow the user to change their password.
        $jsonRaw = $request->getContent();
        $jsonData = json_decode($jsonRaw);
        $errors = $this->validator->validate($jsonData->password, [
            new IdenticalTo($jsonData->password_confirm),
            new NotBlank(['message' => 'Entrez un mot de passe'])
        ]);

        if (count($errors) > 0) {
            return $this->json([
                $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $jsonData->password
            );

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'message' => 'Votre mot de passe a été changé avec succès'
        ], Response::HTTP_OK);



    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): void
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if ($user) {
            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);
                $email = (new TemplatedEmail())
                    ->from(new Address('no-reply@info-smart-solutions.com', 'Info Smart Solutions'))
                    ->to($user->getEmail())
                    ->subject('Your password reset request')
                    ->htmlTemplate('reset_password/email.html.twig')
                    ->context([
                        'resetToken' => $resetToken,
                    ]);

                $mailer->send($email);
            } catch (ResetPasswordExceptionInterface | TransportExceptionInterface $e) {

            }
        }
    }
}
