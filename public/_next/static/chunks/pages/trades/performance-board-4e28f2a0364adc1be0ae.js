(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[423],{244:function(e,r,t){"use strict";t.d(r,{x:function(){return p}});var n=t(2809),a=t(266),o=t(809),s=t.n(o),i=t(7294),l=t(9669),c=t.n(l),u=t(9742);function d(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,n)}return t}function f(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?d(Object(t),!0).forEach((function(r){(0,n.Z)(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):d(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}var p=function(){var e=(0,i.useState)(!1),r=e[0],t=e[1],n=(0,i.useContext)(u.Vo),o=(0,i.useRef)([]),l=(0,i.useCallback)(function(){var e=(0,a.Z)(s().mark((function e(r){var a,i,l,u=arguments;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=u.length>1&&void 0!==u[1]?u[1]:{},t(!0),i=new AbortController,o.current.push(i),e.prev=4,e.next=7,c()(r,f(f({},a),{},{headers:f(f({},a.headers),{},{Accept:"application/ld+json"},n.token&&{Authorization:"Bearer ".concat(n.token)}),signal:i.signal,baseURL:"https://tradingjournal.solutionswebelegantes.fr"}));case 7:return l=e.sent,o.current=o.current.filter((function(e){return e!==i})),t(!1),e.abrupt("return",l);case 13:throw e.prev=13,e.t0=e.catch(4),t(!1),e.t0.response;case 17:case"end":return e.stop()}}),e,null,[[4,13]])})));return function(r){return e.apply(this,arguments)}}(),[n.token]);return(0,i.useEffect)((function(){return function(){o.current.forEach((function(e){return e.abort()}))}}),[]),{isLoading:r,axiosRequest:l}}},9116:function(e,r,t){"use strict";t.r(r),t.d(r,{default:function(){return b}});var n=t(266),a=t(809),o=t.n(a),s=t(1163),i=t(7294),l=t(9742),c=t(8129),u=t(244),d=t(871),f=t(7561),p=t(5893),g=function(e){(0,i.useContext)(l.Vo),(0,s.useRouter)();for(var r=(0,u.x)(),t=(r.isLoading,r.axiosRequest,(0,i.useContext)(c.t),{labels:(0,f.w6)(1,e.cumulativePerformance.length),datasets:[{label:"Profit en %",data:e.cumulativePerformance.map((function(e){return e.cumulative_sum})),fill:!1,backgroundColor:"rgb(255, 99, 132)",borderColor:"rgba(255, 99, 132)"}]}),n=[],a=[],o=0;o<e.performanceByMonth.length;o++){var g=e.performanceByMonth[o];n.push(g.month+"/"+g.year),a.push(parseFloat(g.ratio))}var b={labels:n,datasets:[{label:"Profit en %",data:a,backgroundColor:["rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)","rgba(153, 102, 255, 1)","rgba(255, 159, 64, 1)"],borderColor:["rgba(255, 99, 132, 1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)","rgba(153, 102, 255, 1)","rgba(255, 159, 64, 1)"],borderWidth:1}]};return(0,p.jsx)("div",{className:"w-full",children:(0,p.jsxs)("div",{className:"grid md:grid-cols-2 sm:grid-cols-1 gap-4 w-full px-4",children:[(0,p.jsxs)("div",{className:"font-bold md:col-span-2 flex justify-around  bg-white text-gray-700 dark:bg-gray-700 dark:text-gray-100 shadow rounded-lg w-full md:max-w-lg mx-auto p-4",children:[(0,p.jsxs)("div",{className:"text-center",children:[(0,p.jsxs)("div",{className:"text-2xl ",children:[e.totalRatio,"%"]}),(0,p.jsx)("div",{children:(0,p.jsx)("span",{children:"Profit total"})})]}),(0,p.jsxs)("div",{className:"text-center",children:[(0,p.jsx)("div",{className:"text-2xl ",children:e.totalTrades}),(0,p.jsx)("div",{children:(0,p.jsx)("span",{children:"Trades au total"})})]})]}),(0,p.jsx)("div",{className:"bg-white dark:bg-gray-800 shadow rounded-lg w-full md:max-w-lg mx-auto p-4",children:(0,p.jsx)(d.x1,{data:t,options:{responsive:!0,elements:{point:{radius:3}},scales:{x:{display:!1},y:{beginAtZero:!0,grace:"5%"}},plugins:{legend:{display:!1},title:{display:!0,text:"Performances des 12 derniers mois"}}}})}),(0,p.jsx)("div",{className:"bg-white dark:bg-gray-800 shadow rounded-lg w-full md:max-w-lg mx-auto p-4",children:(0,p.jsx)(d.$Q,{data:b,options:{elements:{bar:{borderWidth:2}},responsive:!0,scales:{y:{beginAtZero:!0,grace:"5%"}},plugins:{legend:{display:!1},title:{display:!0,text:"Performance mensuelle"}}}})})]})})},b=(0,l.FR)((function(){var e=(0,i.useState)(),r=e[0],t=e[1],a=(0,u.x)(),c=(a.isLoading,a.axiosRequest),d=((0,s.useRouter)(),(0,i.useContext)(l.Vo),(0,i.useCallback)((0,n.Z)(o().mark((function e(){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,c("/api/performance");case 3:r=e.sent,t(r.data),e.next=9;break;case 7:e.prev=7,e.t0=e.catch(0);case 9:case"end":return e.stop()}}),e,null,[[0,7]])}))),[c]));return(0,i.useEffect)((function(){d()}),[d]),(0,p.jsx)(g,{totalTrades:(null===r||void 0===r?void 0:r.totalTrades)||0,totalRatio:(null===r||void 0===r?void 0:r.totalPerformance)||0,performanceByMonth:(null===r||void 0===r?void 0:r.groupByMonth)||[],cumulativePerformance:(null===r||void 0===r?void 0:r.byTradePerformance)||[]})}),"ROLE_USER")},8850:function(e,r,t){(window.__NEXT_P=window.__NEXT_P||[]).push(["/trades/performance-board",function(){return t(9116)}])}},function(e){e.O(0,[570,170,982,774,888,179],(function(){return r=8850,e(e.s=r);var r}));var r=e.O();_N_E=r}]);