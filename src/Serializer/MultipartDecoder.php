<?php

namespace App\Serializer;


class MultipartDecoder //implements DecoderInterface
{
    /*public const FORMAT = 'multipart';
    public function __construct(private RequestStack $requestStack) {}
    public function decode($data, $format, array $context = [])
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return null;
        }

        return array_map(static function (string $element) {
                // Multipart form values will be encoded in JSON.
                $decoded = json_decode($element, true);
                return is_array($decoded) ? $decoded : $element;
            }, $request->request->all()) + $request->files->all();
    }

    public function supportsDecoding($format): bool
    {
        return self::FORMAT === $format;
    }*/
}
