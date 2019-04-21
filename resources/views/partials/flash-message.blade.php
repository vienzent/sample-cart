@if(has_flash_message())

    @foreach(get_flash_messages() as $message)

        <div class="alert alert-{{ $message['type'] }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            @if($message['is_list'])
                <ul>
                    @foreach($message['message'] as $m)
                        <li>{!! $m !!}</li>
                    @endforeach
                </ul>

            @else
                {!! $message['message'] !!}
            @endif

        </div>
    @endforeach
    <?php clear_flash_messages(); ?>
@endif