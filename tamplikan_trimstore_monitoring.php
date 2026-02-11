<?php
   require_once 'core/init.php';
   require_once 'view/header_dashboard.php';
?>

<html>
   <head>
      <link rel="icon" href="img/icon.PNG">
      <style>
         body{
            overflow: hidden;
         }

         .hideUpdate{
            display: none;
         }
         .showUpdate{
            display: block;
         }

         .hideNew{
            display: none;
         }
         .showNew{
            display: block;
         }

         .card.color{
            /* box-shadow: 0 0 10px rgba(255, 0, 0, 0.5) */
            box-shadow: 0 0 10px #7B4CFF
         }

         @keyframes bounce {
            0%, 100% {
               transform: translateY(0);
            }
            50% {
               transform: translateY(-20px); 
            }
         }

         @keyframes shake {
         10%, 90% {
            transform: translate3d(-1px, 0, 0);
         }
         20%, 80% {
            transform: translate3d(2px, 0, 0);
         }
         30%, 50%, 70% {
            transform: translate3d(-4px, 0, 0);
         }
         40%, 60% {
            transform: translate3d(4px, 0, 0);
         }
         }            

         .bouncing-animation {
            animation: bounce 4s ease-in-out; 
         }

         .shake-animation {
            animation: shake 5s cubic-bezier(.36,.07,.19,.97) both;
            transform: translate3d(0, 0, 0); /* Force hardware acceleration */
            backface-visibility: hidden; /* Prevent flickering */
            perspective: 1000px; /* Prevent flickering */
         }         
         
         .sticky-bottom{
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%
         }
      </style>
   </head>
   <body class="g-sidenav-show" onload="showTime()">
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
         <div class="container-fluid py-2">
            <svg class="position-absolute top-0" width="2000" height="2000" viewBox="0 0 1231 1421" fill="none" xmlns="http://www.w3.org/2000/svg">
               <g opacity="0.12786" filter="url(#filter0_f_31_15)">
                  <ellipse cx="811.5" cy="602.5" rx="675.5" ry="682.5" fill="url(#paint0_linear_31_15)" />
               </g>
               <defs>
                  <filter id="filter0_f_31_15" x="0.085907" y="-215.914" width="1622.83" height="1636.83" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                     <feFlood flood-opacity="0" result="BackgroundImageFix" />
                     <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                     <feGaussianBlur stdDeviation="67.957" result="effect1_foregroundBlur_31_15" />
                  </filter>
                  <linearGradient id="paint0_linear_31_15" x1="804.405" y1="-136.203" x2="160.281" y2="643.776" gradientUnits="userSpaceOnUse">
                     <stop stop-color="#7B4CFF" />
                     <stop offset="0.469471" stop-color="#25ec4dff" />
                     <stop offset="1" stop-color="white" />
                  </linearGradient>
               </defs>
            </svg>

            <div class="row mb-1 px-1">
               <h3 class="mb-0 h4 font-weight-bolder" id="textTitle">Trimstore Screen Output Result</h3>
               <p class="mb-4">
                  (Menampilkan Hasil Scan Trimstore).
               </p>
            </div>

            <div class="row" id="cardContainer">
            </div>
         </div>

      </main>
      <script src="assets/Chart.js"></script>
      <script>
         var textTitle = $('#textTitle').text();
         var orcs = [];
         var target = 0
         $(document).ready(function(){
            var trimstore = new WebSocket("ws://192.168.90.100:10000/?service=trimstore");         
            // var trimstore = new WebSocket("ws://localhost:10000/?service=trimstore");

            initOutputTrimstore();

            function initOutputTrimstore(){
               $.when(fetch_trimstoreOutputToday(), fetch_trimstoreOutputTotal()).done(function(rst1, rst2){
                  loadInitOutputTrimstore(rst1, rst2);
               });
            }
            
            function fetch_trimstoreOutputToday(){
               try{
                  var response1 = $.ajax({
                     type: 'GET',
                     url: 'functions/ajax_functions_handler.php',
                     data: {action: 'ajax_getTrimstoreOutputToday'},
                     dataType: 'JSON'
                  });
                  return response1;
               }catch(err){
                  throw err;
               }
            }

            function fetch_trimstoreOutputTotal(){
               try{
                  var response2 = $.ajax({
                     type: 'GET',
                     url: 'functions/ajax_functions_handler.php',
                     data: {action: 'ajax_getTrimstoreOutputTotal'},
                     dataType: 'JSON'
                  });
                  return response2;
               }catch(err){
                  throw err;
               }               
            }
  
            function loadInitOutputTrimstore(resp1, resp2){
               console.log('resp1: ', resp1);
               console.log('resp2: ', resp2);
               // const summedByORCToday = resp1.reduce((acc1, curr1) => {
               //    const found1 = acc1.find(val1 => val1.orc === curr1.orc);
               //    if(found1){
               //       found1.qty += parseInt(curr1.qty);
               //    }else{
               //       acc1.push({...curr1, qty: parseInt(curr1.qty)});
               //    }
               //    return acc1;
               // }, []);

               $.each(resp1[0], function(i, item1){
                  $.each(resp2[0], function(j, item2){
                     if(item1.orc == item2.orc){
                        let orc = item1.orc;
                        orcs.push(orc);
                        $('#cardContainer').append(
                           `<div class="col-xl-3 col-sm-6 mb-4 fadeIn-Animate" style="display: none;" id="${orc}">
                              <div class="card color p-1">
                                    <div class="card-header p-2 ps-2">
                                       <div class="row">
                                          <div class="col-sm-8">
                                             <div class="row">
                                                <p class="mb-0 text-sm text-success"><strong>${item1.orc}</strong></p>
                                                <p class="mb-0 text-sm text-dark"><strong>${item1.plan_line}</strong></p>
                                             </div>
                                          </div>
                                          <div class="col-sm-4">
                                             <span class="badge rounded-pill bg-warning hideUpdate" id="updated-${orc}">Updated</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr class="dark horizontal my-0">
                                    <div class="card-footer p-2 ps-2 bg-gradient-dark">
                                       <div class="d-flex justify-content-around">
                                          <div>
                                             <p class="text-sm mb-0 text-warning text-center"><strong>Qty Order</strong></p>
                                             <h4 class="mb-0 text-warning text-center" id="qtyOrder-${orc}"><strong>${item1.qty_order}</strong></h4>
                                          </div>

                                          <div>
                                             <p class="text-sm mb-0 text-capitalize text-success text-center"><strong>Today</strong></p>
                                             <h4 class="mb-0 text-success text-center" id="output-today-${orc}"><strong>${item1.total_qty}</strong></h4>
                                          </div>

                                          <div>
                                             <p class="text-sm mb-0 text-capitalize text-success text-center"><strong>Total</strong></p>
                                             <h4 class="mb-0 text-success text-center" id="output-total-${orc}"><strong>${item2.total_qty}</strong></h4>
                                          </div>

                                          <div>
                                             <p class="text-sm mb-0 text-white text-center"><strong>W I P</strong></p>
                                             <h4 class="mb-0 text-white text-center" id="wip-${orc}"><strong>${parseInt(item1.qty_order)-parseInt(item2.total_qty)}</strong></h4>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>`                  
                        );
                     }
                  });

               });
               console.log('orcs: ', orcs);

               // Fade in and bouncing animation
               $('.fadeIn-Animate').each(function(idx){
                  let $this = $(this);
                  let delayTime = idx * 300;

                  $this.delay(delayTime).fadeIn(1000, function(){
                     $this.removeClass("fadeIn-Animate");
                  }).addClass("bouncing-animation");
               });

               // remove bouncing animation class
               // let duration = 4 * 
               $.each(orcs, function(i, itm){
                  console.log('itm: ', itm);
                  let card = $(`#${itm}`);
                  card.on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function(){
                     card.removeClass('bouncing-animation');
                  })
               })
            }
   
            trimstore.onmessage = function(msg){
               var objDataTrimstoreOnMessage = JSON.parse(msg.data);
   
               var orc = objDataTrimstoreOnMessage[0].orc;
               // var style = objDataQCEndlineOnMessage.dataEff[0].style;
               
               let found = orcs.find(o => o === orc);
               if(found != undefined){
                  let newQTY = 0;
                  $.each(objDataTrimstoreOnMessage, function(i, item){
                     newQTY += parseInt(item.qty);
                  });
                  $(`#output-today-${orc}`).text(newQTY);
                  $(`#${line}`).toggleClass('bouncing-animation');
                  // $(`#output-today-${line}`).addClass('bouncing-animation');
                  // setTimeout(() => {
                  //    $(`#output-today-${line}`).removeClass('bouncing-animation');
                  //    $(`#${line}`).removeClass('bouncing-animation');
                  // }, 1000);
                  $(`#updated-${orc}`).removeClass('hideUpdate');
                  $(`#updated-${orc}`).addClass('showUpdate');
                  $(`#updated-${orc}`).fadeOut(5*60*1000, function(){
                     $(`#updated-${orc}`).removeClass('showUpdate');
                     $(`#updated-${orc}`).addClass('hideUpdate');
                  });

               }else{
                  // AddOutputTrimstore(orc, style, objDataQCEndlineOnMessage.dataOutput[0].today);
               }
            }

            function AddOutputTrimstore(ln, st, output){
               var realLine = ln.slice(0,4) + " " + ln.slice(4);

               $.when(fetchQCEndlinePerLineYesterday(realLine), fetchQCEndlineTarget(realLine)).done(function(rst1, rst2){
                  console.log('rst1: ', rst1);
                  var qtyYesterday = 0;
                  
                  if(rst1[0].length > 0){
                     const summedByLineYesterday1 = rst1[0].reduce((a, c) => {
                        const f = a.find(v => v.line === c.line);
                        if(f){
                           f.qty += parseInt(c.qty);
                        }else{
                           a.push({...c, qty: parseInt(c.qty)});
                        }
                        return a;
                     }, []);

                     console.log('summedByLineYesterday1: ', summedByLineYesterday1);
                     qtyYesterday = summedByLineYesterday1[0].qty;
   
                     lines.push(ln);

                  }
                  console.log('qtyYesterday: ', qtyYesterday);
                  // target = rst2[0].target;

                  $('#cardContainer').append(
                     `<div class="col-xl-2 col-sm-6 mb-4" id="${ln}">
                           <div class="card color p-1">
                              <div class="card-header p-2 ps-2">
                                 <div class="row">
                                    <div class="col-sm-8">
                                       <p class="mb-0 text-sm">
                                          <span class="text-success font-weight-bolder">
                                             ${realLine} <span class="text-dark">(${st})</span>
                                          </span>
                                       </p>
                                    </div>
                                    <div class="col-sm-4">
                                       <span class="badge rounded-pill bg-danger hideNew" id="updated-${ln}">New</span>
                                    </div>
                                 </div>
                              </div>
                              <hr class="dark horizontal my-0">
                              <div class="card-footer p-2 ps-2 bg-gradient-dark">
                                 <div class="d-flex justify-content-between">
                                    <div>
                                       <p class="text-sm mb-0 text-warning text-center">Target</p>
                                       <h4 class="mb-0 text-warning text-center" id="target-${ln}">${(rst2[0] == null ? 'blm diisi' : rst2[0].target)}</h4>
                                    </div>
                                    <div>
                                       <p class="text-sm mb-0 text-capitalize text-success text-center">Today</p>
                                       <h4 class="mb-0 text-success text-center" id="output-today-${ln}"><strong>${output}</strong></h4>
                                    </div>
                                    <div>
                                       <p class="text-sm mb-0 text-white text-center">Yesterday</p>
                                       <h4 class="mb-0 text-white text-center" id="output-yesterday-${ln}">${(isNaN(qtyYesterday) ? "tidak ada" : qtyYesterday)}</h4>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>`
                  );
                  
                  $(`#${ln}`).addClass('bouncing-animation');
                  setTimeout(() => {
                     $(`#${ln}`).removeClass('bouncing-animation');
                  }, 1000);

                  $(`#updated-${ln}`).removeClass('hideNew');

                  $(`#updated-${ln}`).addClass('showNew');

                  $(`#updated-${ln}`).fadeOut(5*60*1000, function(){
                     $(`#updated-${ln}`).removeClass('showNew');
                     $(`#updated-${ln}`).addClass('hideUpdate');
                  });                  

               });

               // $.ajax({
               //    type: 'GET',
               //    url: 'functions/ajax_functions_handler.php',
               //    data: {
               //       action: 'ajax_getQCEndlinePerLineYesterday',
               //       param: {
               //          'line': realLine
               //       }
               //    },
               //    dataType: 'JSON'
               // }).done(function(result){
               //    console.log('result: ', result);
               //    var qtyYesterday = 0;
                  
               //    if(result.length > 0){
               //       const summedByLineYesterday1 = result.reduce((a, c) => {
               //          const f = a.find(v => v.line === c.line);
               //          if(f){
               //             f.qty += parseInt(c.qty);
               //          }else{
               //             a.push({...c, qty: parseInt(c.qty)});
               //          }
               //          return a;
               //       }, []);

               //       qtyYesterday = summedByLineYesterday1[0].qty;
   
               //       console.log('summedByLineYesterday1: ', summedByLineYesterday1);
               //       lines.push(ln);
               //    }


               //    // $(`#updated-${line}`).addClass('showUpdate');
               // });

            }

         });

         function showTime(){
            const date = new Date();
            let h = date.getHours();
            let m = date.getMinutes();
            let s = date.getSeconds();

            h = (h < 10) ? h = "0" + h : h;
            m = (m < 10) ? m = "0" + m : m;
            s = (s < 10) ? s = "0" + s : s;

            let time = h + ":" + m + ":" + s;
            $('#textTitle').text(textTitle + " - <?=date('d/m/Y'); ?> " + "(" + time + ")");
            setTimeout(showTime, 1000);            
         }
      </script>
   </body>
</html>
