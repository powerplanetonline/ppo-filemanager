<div class="row">

  @if((sizeof($file_info) > 0) || (sizeof($directories) > 0))

  @foreach($directories as $key => $dir_name)
  @include('ppo-filemanager::folders')
  @endforeach

  @foreach($file_info as $key => $file)
  @include('ppo-filemanager::item')
  @endforeach

  @else
  <div class="col-md-12">
    <p>{{ Lang::get('ppo-filemanager::lfm.message-empty') }}</p>
  </div>
  @endif

</div>
