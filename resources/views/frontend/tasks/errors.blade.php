@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div id="check-car-error" style="display: none">
	<div class="alert alert-danger">
        <ul>
                <li id="message-error">
                </li>
        </ul>
    </div>
</div>
