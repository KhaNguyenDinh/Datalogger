
    <section class="section">
      <div class="row">
      	@foreach ($camera as $key => $value)
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{$value['name_camera']}}</h5>
              <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <iframe src="https://live.cae.vn/image?name={{$value['name_camera']}}"
	        width="500" height="400" frameborder="0" allowfullscreen></iframe>
	              </div>
	            </div>
	           </div><!-- End Slides only carousel-->
	         </div>
	      </div>
	    </div>
	    @endforeach
	  </div>
    </section>