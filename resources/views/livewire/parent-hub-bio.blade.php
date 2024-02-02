<div wire:poll>
   


<div class="row">





<div class="col-xs-12 col-sm-6 ">
    <a href="{{ URL::to("/child-hub") }}" >   
      <div class="card" style="padding: 20px;">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                
                <h4 class="font-weight-bolder mb-0" >
                  
                  Fee<br/>
                </h>

                <h6 class="font-weight-bolder mb-0" >
                   @livewire("childhub-funds")
                </h6>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-money-bill fa-3x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  </a>
  <br/>
</div>

<div class="col-xs-12 col-sm-6 ">
    <a href="{{ URL::to("/child-hub") }}" >   
      <div class="card" style="padding: 20px;">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                
                <h4 class="font-weight-bolder mb-0" >
                  
                   No of kid(s)<br/>
                </h4>

                <h6 class="font-weight-bolder mb-0" >
                   <span style="font-size:33px;">
                  <center>{{number_format($kids)}}</center> 
               </span>
                </h6>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="fa-solid fa-user fa-3x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  </a>
  <br/>
</div>



</div>

</div>


