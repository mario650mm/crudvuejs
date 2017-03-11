<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"/>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="name">@lang('users.name')</label>
        <input type="text" id="name" name="name" class="form-control" v-model="user.name"/>
        <span id="span_name" class="span-red error"></span>
    </div>
    <div class="form-group col-sm-6">
        <label for="email">@lang('users.email')</label>
        <input type="email" id="email" name="email" class="form-control" v-model="user.email"/>
        <span id="span_email" class="span-red error"></span>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="password">@lang('users.password')</label>
        <input type="password" id="password" name="password" class="form-control"/>
        <span id="span_password" class="span-red error"></span>
    </div>
    <div class="form-group col-sm-6">
        <label for="password_confirmation">@lang('users.password_confirmation')</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
        <span id="span_password_confirmation" class="span-red error"></span>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        <label for="countrys">@lang('users.country')</label>
        <select id="countrys" name="countrys" class="form-control selectpicker" data-live-search="true"
                v-model="user.country_id" v-on:change="selectedCountry()">
            <option data-hidden="true" value="">@lang('users.select_country')</option>
            <option v-for="country in countrys" :value="country.id">@{{country.name}}</option>
        </select>
        <br>
        <span id="span_countrys" class="span-red error"></span>
    </div>
    <div class="form-group col-sm-4">
        <label for="states">@lang('users.state')</label>
        <select id="states" name="states" class="form-control selectpicker" data-live-search="true"
                v-model="user.state_id" v-on:change="selectedState()">
            <option data-hidden="true" value="">@lang('users.select_state')</option>
            <option v-for="state in states" :value="state.id">@{{state.name}}</option>
        </select>
        <br>
        <span id="span_states" class="span-red error"></span>
    </div>
    <div class="form-group col-sm-4">
        <label for="citys">@lang('users.city')</label>
        <select id="citys" name="citys" class="form-control selectpicker"
                data-live-search="true" v-model="user.city_id">
            <option data-hidden="true" value="">@lang('users.select_city')</option>
            <option v-for="city in citys" :value="city.id">@{{city.name}}</option>
        </select>
        <br>
        <span id="span_citys" class="span-red error"></span>
    </div>
</div>