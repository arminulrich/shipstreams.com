<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/submit">

                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="email">E-Mail *</label>
                        <input id="email" type="email"
                               class="form-control @if($errors->has('email')) is-invalid @endif" name="email"
                               value="{{old('email')}}"
                        />
                    </div>
                    <div class="form-group">
                        <label for="twitch_username">Twitch Username *</label>
                        <input id="twitch_username" type="text"
                               class="form-control @if($errors->has('twitch_username')) is-invalid @endif"
                               name="twitch_username"
                               value="{{old('twitch_username')}}"
                        />
                    </div>
                    <div class="form-group">
                        <label for="twitter_handle">Twitter Handle</label>
                        <input id="twitter_handle" type="text"
                               class="form-control @if($errors->has('twitter_handle')) is-invalid @endif"
                               name="twitter_handle"
                               value="{{old('twitter_handle')}}"
                        />
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input id="website" type="url"
                               class="form-control @if($errors->has('website')) is-invalid @endif"
                               value="{{old('website')}}"
                               name="website"/>
                    </div>

                    <button class="btn btn-danger mt-2" type="submit">Submit!</button>
                </form>

            </div>
        </div>

    </div>
</div>