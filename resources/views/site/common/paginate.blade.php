<?php
  // config
  $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>
@if($paginator->lastPage() > 1)
  <ul class="pagination justify-content-center mt-3">
    @if($paginator->currentPage() == 1)
    <li class="page-item disabled">
      <a class="page-link" href="#" aria-label="First">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    @else
    <li class="page-item">
      <a class="page-link" href="{{ preg_replace('/(\?|&)page=1/', '', $paginator->url(1)) }}" aria-label="First">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    @endif
    @for($i = 1; $i <= $paginator->lastPage(); $i++)
      <?php
        $half_total_links = floor($link_limit / 2);
        $from = $paginator->currentPage() - $half_total_links;
        $to = $paginator->currentPage() + $half_total_links;
        if($paginator->currentPage() < $half_total_links) {
           $to += $half_total_links - $paginator->currentPage();
        }
        if($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
            $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
        }
        if($i == 1) {
          $pageUrl = preg_replace('/(\?|&)page=1/', '', $paginator->url($i));
        } else {
          $pageUrl = $paginator->url($i);
        }
      ?>
      @if($from < $i && $i < $to)
          @if($paginator->currentPage() == $i)
          <li class="page-item active">
              <a class="page-link" href="#">{{ $i }} <span class="sr-only">(current)</span></a>
          </li>
          @else
          <li class="page-item">
              <a class="page-link" href="{{ $pageUrl }}">{{ $i }}</a>
          </li>
          @endif
      @endif
    @endfor
    @if($paginator->currentPage() == $paginator->lastPage())
    <li class="page-item disabled">
      <a class="page-link" href="#" aria-label="Last">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Last</span>
      </a>
    </li>
    @else
    <li class="page-item">
      <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Last</span>
      </a>
    </li>
    @endif
  </ul>
@endif