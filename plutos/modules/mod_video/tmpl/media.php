<div class="container">
    <h1>Play YouTube or Vimeo Videos in Bootstrap 4 Modal</h1>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/Jfrjeg26Cwk" data-target="#myModal">
        Play Video 1
    </button>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/IP7uGKgJL8U" data-target="#myModal">
        Play Video 2
    </button>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/A-twOC3W558" data-target="#myModal">
        Play Video 3
    </button>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://player.vimeo.com/video/58385453?badge=0" data-target="#myModal">
        Play Vimeo Video
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>        
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always">></iframe>
                    </div>


                </div>

            </div>
        </div>
    </div> 
</div>


