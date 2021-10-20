@if($is_visible)
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1">
        {{ $name }} Discord
        <i class="fab fa-discord float-end m-1"></i>
      </h5>
    </div>
    <div class="card-body p-0 table-responsive">
      <table class="table table-borderless table-sm table-striped text-end align-middle mb-0">
        @foreach($members->sortBy('username') as $member)
          <tr>
            <td class="text-start">
              @if(filled($member->avatar_url))
                <img class="me-1" src="{{ $member->avatar_url }}" style="max-height: 30px;">
              @endif
              {{ $member->username }}
            </td>
            <td>{{ $member->game->name ?? '' }}</td>
            <td>{{ ucfirst($member->status) }}</td>
          </tr>
        @endforeach
      </table>
    </div>
    <div class="card-footer p-1 text-end small">
      <span class="float-start">
        {{ count($members) }} @lang('DBasic::widgets.donline')
        @if(count($channels) > 0)
          {{ ' | '.count($channels) }} @lang('DBasic::widgets.dchannels')
        @endif
      </span>
      @if(filled($invite))
        <a class="button btn-sm btn-success m-0 p-0 py-2" href="{{ $invite }}" target="_blank">@lang('DBasic::widgets.djoin')</a>
      @endif
    </div>
  </div>
@endif
