var timer=0;var actions={};var seconds={};var logic={};var interval={};var duration={};var done={};function mycred_view_video(id,state,custom_logic,custom_interval,key,ctype){var videoid=id;var videostate=state;if(actions[id]===undefined)
actions[id]='';if(seconds[id]===undefined)
seconds[id]=0;if(custom_logic=='0')
logic[id]=myCRED_Video.default_logic;else
logic[id]=custom_logic;if(custom_interval=='0')
interval[id]=parseInt(myCRED_Video.default_interval,10);else
interval[id]=parseInt(custom_interval,10);if(videostate!='-1'){if(logic[id]=='play'){if(videostate==1&&done[id]===undefined)
mycred_video_call(videoid,key,videostate,'','',ctype);}
else if(logic[id]=='full'){actions[id]=actions[id]+state.toString();if(state==1){timer=setInterval(function(){seconds[id]=seconds[id]+1;},1000);}
else if(state==0){clearInterval(timer);mycred_video_call(videoid,key,videostate,actions[videoid],seconds[videoid],ctype);seconds[id]=0;actions[id]='';}
else{clearInterval(timer);}}
else if(logic[id]=='interval'){actions[id]=actions[id]+state.toString();if(state==1){timer=window.setInterval(function(){var laps=parseInt(interval[id]/1000,10);seconds[id]=seconds[id]+laps;mycred_video_call(videoid,key,videostate,actions[videoid],seconds[videoid],ctype);},interval[id]);}
else if(state==0){clearInterval(timer);mycred_video_call(videoid,key,videostate,actions[videoid],seconds[videoid],ctype);seconds[id]=0;actions[id]='';}
else{clearInterval(timer);}}}}
function mycred_video_call(id,key,state,actions,seconds,pointtype){if(done[id]===undefined){if(duration[id]===undefined)
duration[id]=0;jQuery.ajax({type:"POST",data:{action:'mycred-viewing-videos',token:myCRED_Video.token,setup:key,video_a:actions,video_b:seconds,video_c:duration[id],video_d:state,type:pointtype},dataType:"JSON",url:myCRED_Video.ajaxurl,success:function(response){if(response.status==='max')
done[id]=response.amount;}});}};