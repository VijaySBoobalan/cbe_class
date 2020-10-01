	 <style>				
	 .media.chatsview {
    background: aquamarine;
    padding: 0px -3px;
    margin-bottom: -13px;
}
	 </style>				
                        <!-- tile body -->
                        <div class="tile-body slim-scroll" style="max-height: 320px;overflow:auto;">

                            <ul class="chats p-0">
							@foreach($messages as $msg)
                                <li class=<?php if($msg['commenter_id']==auth()->user()->id) { echo "in";}else{ echo "out";} ?>>
                                    <div class="media chatsview">
                                        <div class="<?php if($msg['commenter_id']==auth()->user()->id) { echo "pull-left";}else{ echo "pull-right";} ?> thumb thumb-sm">
                                            <img class="media-object img-circle" src="{{ url('assets/images/profile-photo.jpg') }}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name"><?php if($msg['commenter_id']==auth()->user()->id) {echo "You";} else { echo $msg['name'];} ?></a><span class="datetime"> at <?php echo get_time_ago($msg['commented_at']); ?></span></p>
                                            <span class="body">{{ $msg['message']}}</span>
                                        </div>
                                    </div>
                                </li>
                              
							@endforeach
                            </ul>

                        </div>
						<?php
					 function get_time_ago($time_ago){        
	      
	        date_default_timezone_set('Asia/Kolkata');
	        $dt = new DateTime('now', new DateTimezone('Asia/Kolkata'));
	        $date_time = strtotime($dt->format('Y-m-d H:i:s')); 

	        $time_ago = strtotime($time_ago);
	        $cur_time   = $date_time;
	        $time_elapsed   = $cur_time - $time_ago;
	        $seconds    = $time_elapsed ;
	        $minutes    = round($time_elapsed / 60 );
	        $hours      = round($time_elapsed / 3600);
	        $days       = round($time_elapsed / 86400 );
	        $weeks      = round($time_elapsed / 604800);
	        $months     = round($time_elapsed / 2600640 );
	        $years      = round($time_elapsed / 31207680 );
	        // Seconds


	        if($seconds <= 60){
	            return "just now";
	        }
	        //Minutes
	        else if($minutes <=60){
	            if($minutes==1){
	                return "one minute ago";
	            }
	            else{
	                return "$minutes minutes ago";
	            }
	        }
	        //Hours
	        else if($hours <=24){
	            if($hours==1){
	                return "an hour ago";
	            }else{
	                return "$hours hrs ago";
	            }
	        }
	        //Days
	        else if($days <= 7){
	            if($days==1){
	                return "yesterday";
	            }else{
	                return "$days days ago";
	            }
	        }
	        //Weeks
	        else if($weeks <= 4.3){
	            if($weeks==1){
	                return "a week ago";
	            }else{
	                return "$weeks weeks ago";
	            }
	        }
	        //Months
	        else if($months <=12){
	            if($months==1){
	                return "a month ago";
	            }else{
	                return "$months months ago";
	            }
	        }
	        //Years
	        else{
	            if($years==1){
	                return "one year ago";
	            }else{
	                return "$years years ago";
	            }
	        }


	        
	    }
						?>
                     

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	 $(document).ready(function(){
            $("ul.chats p-0").scrollTop(2000);
				
         });
	</script>