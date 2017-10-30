<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('vendor/supersu/compiled/css/app.css') }}">

<div class="superSu">
    <div class="superSu__btn {{ $hasSupered ? 'superSu__btn--hasSupered' : '' }}" id="supersu-js-btn">
        <i class="fa fa-user-secret" aria-hidden="true"></i>
    </div>
    
    <div class="superSu__interface {{ $hasSupered ? 'superSu__interface--hasSupered' : '' }} hidden" id="supersu-js-interface">
        @if ($hasSupered)
            <div class="superSu__infoLine">
                You are using account: <span>{{ $currentUser->name }}</span>
            </div>
            
            @if ($originalUser)
                <div class="superSu__infoLine">
                    You are logged in as: <span>{{ $originalUser->name }}</span>
                </div>
            @endif
            
            <form action="{{ route('supersu.return') }}" method="post">
                {!! csrf_field() !!}
                <input type="submit" class="superSu__resetBtn" value="{{ $originalUser ? 'Return to original user' : 'Log out' }}">
            </form>
        @endif

        <form action="{{ route('supersu.login_as_user') }}" method="post">
            <select name="userId" onchange="this.form.submit()">
                <option disabled selected>Super Su</option>

                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            
            {!! csrf_field() !!}

            <input type="hidden" name="originalUserId" value="{{ $originalUser->id ?? null }}">
        </form>
    </div>
</div>

<script>
    const btn = document.getElementById('supersu-js-btn');
    const element = document.getElementById('supersu-js-interface');

    btn.addEventListener('click', event => element.classList.toggle('hidden'));
</script>