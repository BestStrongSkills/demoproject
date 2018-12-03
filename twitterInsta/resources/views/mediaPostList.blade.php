@foreach($instagramMedia as $key => $value)
  <div class="item">
    <a href="{{ route('starIndivisual', $value['shortCode']) }}">
      <img src="{{ $value['thumbnail'] }}" class="img-fluid" alt="grid_1">
      <div class="item-content">
        <p>{{ $value['caption'] }}</p>
        <time>{{ date('Y.m.d', $value['createdAt']) }}</time>
        <span class="badge">New</span>
      </div>
    </a>
  </div>
@endforeach