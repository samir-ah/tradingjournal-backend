(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[405],{5498:function(e,n,t){"use strict";t.d(n,{Z:function(){return i}});var a=t(1664),r=t(9835),s=t.n(r),c=t(5893),u=function(e){return(0,c.jsx)("div",{className:"".concat(s().loader," ml-5"),children:"Loading..."})};var i=function(e){var n=e.link,t=e.className,r=e.onClick,s=e.children,i=e.isLoading;return n?(0,c.jsx)(a.default,{href:n,children:(0,c.jsx)("a",{className:"btn ".concat(t||""),children:s})}):(0,c.jsxs)("button",{className:"btn ".concat(t||""),onClick:r,disabled:i,children:[s,i?(0,c.jsx)("span",{children:(0,c.jsx)(u,{})}):""]})}},2562:function(e,n,t){"use strict";t.r(n);var a=t(9742),r=t(2718),s=t(5893);n.default=(0,a.FR)((function(){return(0,s.jsx)(r.default,{})}),"ROLE_USER")},2718:function(e,n,t){"use strict";t.r(n);var a=t(266),r=t(809),s=t.n(r),c=t(1163),u=t(7294),i=t(3263),o=t(723),d=t(5498),l=t(7130),f=t(5852),p=t(9742),h=t(244),x=t(7561),v=t(5893);n.default=(0,p.FR)((function(){var e,n=(0,u.useState)(),t=n[0],r=n[1],j=(0,c.useRouter)(),_=(0,u.useContext)(p.Vo),m=(0,u.useState)(parseInt((null===(e=j.query.page)||void 0===e?void 0:e.toString())||"1")||1),w=m[0],g=m[1],y=(0,u.useState)(1),k=y[0],b=y[1],N=(0,h.x)(),E=N.isLoading,R=N.axiosRequest,Z=(0,u.useCallback)(function(){var e=(0,a.Z)(s().mark((function e(n){var t,a,c;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,R("/api/trades?author=".concat(_.user.id,"&page=").concat(n));case 3:t=e.sent,r(t.data["hydra:member"]),"hydra:view"in t.data&&"hydra:last"in t.data["hydra:view"]?(a=t.data["hydra:view"],c=(0,x.wR)("page",a["hydra:last"]),b(parseInt(c||"1"))):b(1),e.next=10;break;case 8:e.prev=8,e.t0=e.catch(0);case 10:case"end":return e.stop()}}),e,null,[[0,8]])})));return function(n){return e.apply(this,arguments)}}(),[_.user.id,R]);function C(e){g(e),j.push("/trades/my-trades?page=".concat(e))}function S(){return(S=(0,a.Z)(s().mark((function e(n){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,L(n);case 3:e.sent,t&&t.length>1||w-1===0?Z(w):w-1>0&&C(w-1),e.next=9;break;case 7:e.prev=7,e.t0=e.catch(0);case 9:case"end":return e.stop()}}),e,null,[[0,7]])})))).apply(this,arguments)}function L(e){return P.apply(this,arguments)}function P(){return(P=(0,a.Z)(s().mark((function e(n){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,R("/api/trades/".concat(n),{method:"delete"});case 2:return e.abrupt("return",e.sent);case 3:case"end":return e.stop()}}),e)})))).apply(this,arguments)}return(0,u.useEffect)((function(){Z(w)}),[w,Z]),(0,v.jsxs)("div",{className:"w-full",children:[(0,v.jsx)("div",{className:"flex justify-end mx-3",children:(0,v.jsx)(d.Z,{onClick:function(){j.push("/trades/new-trade")},children:"Ajouter"})}),t&&t.length>0||E?(0,v.jsxs)("div",{className:"mx-auto container py-20 px-6",children:[E?(0,v.jsx)(l.Z,{}):t&&(0,v.jsx)(o.Z,{trades:t,onDeleteTrade:function(e){return S.apply(this,arguments)}}),(0,v.jsx)("div",{className:"flex justify-center mt-10",children:(0,v.jsx)(f.Z,{onPageChange:C,lastPage:k,currentPage:w})})]}):(0,v.jsx)(i.Z,{children:"Aucun trade, veuillez en ajouter"})]})}),"ROLE_USER")},5301:function(e,n,t){(window.__NEXT_P=window.__NEXT_P||[]).push(["/",function(){return t(2562)}])},9835:function(e){e.exports={loader:"loading-btn_loader__1Qjxv",load7:"loading-btn_load7__1_JU2"}}},function(e){e.O(0,[388,170,451,774,888,179],(function(){return n=5301,e(e.s=n);var n}));var n=e.O();_N_E=n}]);