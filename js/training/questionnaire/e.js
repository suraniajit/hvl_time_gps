'use strict';

let log = console.log.bind(console),
  id = val => document.getElementById(val),
  ul = id('ul'),
  gUMbtn = id('gUMbtn'),
   start = id('start'),
//   stop = id('stop'),
  stream,
  recorder,
  counter=1,
  chunks,
  media;


$( "body" ).on('click','#gUMbtn', function(){
  let mediaOptions = {
      
        audio: {
          tag: 'audio',
          type: 'audio/ogg',
          ext: '.ogg',
          gUM: {audio: true}
        }
      };
  media = mediaOptions.audio;
  navigator.mediaDevices.getUserMedia(media.gUM).then(_stream => {
    stream = _stream;
    id('gUMArea').style.display = 'none';
    id('btns').style.display = 'inherit';
    start.removeAttribute('disabled');
    recorder = new MediaRecorder(stream);
    recorder.ondataavailable = e => {
      chunks.push(e.data);
      if(recorder.state == 'inactive')  makeLink();
    };
    log('got media successfully');
  }).catch(log);
  
});

$( "body" ).on('click','#start', function(){
        $("#start").prop('disabled', true);
        $('#stop').prop('disabled', false);
      chunks=[];
      recorder.start();
    });
    
    $( "body" ).on('click','#stop', function(){
        $("#stop").prop('disabled', true);
      recorder.stop();
      $('#start').prop('disabled', false);
    });



function makeLink(){
  let blob = new Blob(chunks, {type: media.type })
    , url = URL.createObjectURL(blob)
    , li = document.createElement('li')
    , mt = document.createElement(media.tag)
    , hf = document.createElement('a')
  ;
  mt.controls = true;
  mt.src = url;
  hf.href = url;
  hf.download = `${counter++}${media.ext}`;
  hf.innerHTML = `donwload ${hf.download}`;
  li.appendChild(mt);
  li.appendChild(hf);
  ul.appendChild(li);
}












// let log = console.log.bind(console),
//   id = val => document.getElementById(val),
//   ul = id('ul'),
//   gUMbtn = id('gUMbtn'),
//   start = id('start'),
//   stop = id('stop'),
//   stream,
//   recorder,
//   counter=1,
//   chunks,
//   media;

// $(document).ready(function() {
//      let mediaOptions = {

//         audio: {
//           tag: 'audio',
//           type: 'audio/ogg',
//           ext: '.ogg',
//           gUM: {audio: true}
//         }
//       };
//   media = mediaOptions.audio;
//   navigator.mediaDevices.getUserMedia(media.gUM).then(_stream => {
//     stream = _stream;
//     // $("#btns").style.display = 'inherit';
//     // start.removeAttribute('disabled');
//     recorder = new MediaRecorder(stream);
//     recorder.ondataavailable = e => {
//       chunks.push(e.data);
//       if(recorder.state == 'inactive')  makeLink();
//     };
//     log('got media successfully');
//   }).catch(log);

   

// });
 

// function makeLink(){
//   let blob = new Blob(chunks, {type: media.type })
//     , url = URL.createObjectURL(blob)
//     , li = document.createElement('li')
//     , mt = document.createElement(media.tag)
//     , hf = document.createElement('a')
//   ;
//   mt.controls = true;
//   mt.src = url;
//   hf.href = url;
//   hf.download = `${counter++}${media.ext}`;
//   hf.innerHTML = `donwload ${hf.download}`;
//   li.appendChild(mt);
//   li.appendChild(hf);
//   ul.appendChild(li);
// }