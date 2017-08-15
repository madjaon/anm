<blockquote class="card-blockquote">
  <ul class="row list-unstyled animated fadeInNew">
    @foreach($post->eps as $value)
    <?php 
      if(getDevice2() == MOBILE) {
        if($value->volume > 0) {
          $name = 'Q ' . $value->volume . ' chương ' . $value->epchap;
        } else {
          $name = 'Chương ' . $value->epchap;
        }
      } else {
        $name = $value->name;
      }
    ?>
      <li class="col-6 blur">
        <a href="{!! CommonUrl::getUrl2($post->slug, $value->slug) !!}" title="{!! $value->name !!}"><i class="fa fa-angle-right mr-2" aria-hidden="true"></i>{!! $name !!}</a>
      </li>
    @endforeach
  </ul>

  @if($post->totalPageEps > 1)
  <footer class="d-flex justify-content-center align-items-center">
    
    @if(isset($post->prevPageEps))
      <button class="btn btn-primary btn-sm" onclick="bookpaging({!! $post->prevPageEps !!})"><i class="fa fa-angle-left mr-2" aria-hidden="true"></i>Trước</button>
    @else
      <button class="btn btn-primary btn-sm disabled"><i class="fa fa-angle-left mr-2" aria-hidden="true"></i>Trước</button>
    @endif

    {!! Form::select(null, $post->listPageEps, $post->currentPageEps, array('class' =>'custom-select form-control-sm mx-2', 'style'=>'width:120px;', 'onchange'=>'bookpaging(this.value)')) !!}

    @if(isset($post->nextPageEps))
      <button class="btn btn-primary btn-sm" onclick="bookpaging({!! $post->nextPageEps !!})">Sau<i class="fa fa-angle-right ml-2" aria-hidden="true"></i></button>
    @else
      <button class="btn btn-primary btn-sm disabled">Sau<i class="fa fa-angle-right ml-2" aria-hidden="true"></i></button>
    @endif
    
  </footer>
  @endif
  
</blockquote>
