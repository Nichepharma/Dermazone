<div class="row">
	<div class="col-md-6">

		<div class="row">
			<div class="col-md-12">
				<h4 class="text-primary">User Wallet (Balance)</h4>

				<table class="table table-striped table-hover table-condensed small">
					<tr class="text-success">
						<td>Currency</td>
						<td>Wallet amount</td>
						<td>Available trade</td>
					</tr>
					@if($wallet->count())
						@foreach($wallet as $wallet_in)
						<tr>
							<td>{{$wallet_in->currency_id}}</td>
							<td>{{ price($wallet_in->wallet_amount) }}</td>
							<td>{{ price($wallet_in->available_trade) }}</td>
						</tr>
						@endforeach
					@else
						<tr><td colspan="3"><label class="label label-danger text-center">{{trans('no_records')}}</label></td></tr>
					@endif
				</table>
			</div>

			<div class="col-md-12">
				<h4 class="text-primary">User Banks</h4>

				<table class="table table-striped table-hover table-condensed small">
					<tr class="text-success">
						<td>Account No.</td>
						<td>Bank</td>
						<td>Balance</td>
					</tr>
					@if($user_banks->count())
						@foreach($user_banks as $bank)
						<tr>
							<td>{{ $bank->account_number}}</td>
							<td>{{ $bank->bank->name }}</td>
							<td>{{ price($bank->balance) }} {{ $bank->currency->code }}</td>
						</tr>
						@endforeach
					@else
						<tr><td colspan="3"><label class="label label-danger text-center">{{trans('no_records')}}</label></td></tr>
					@endif
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<h4 class="text-primary">User Portofolio (Shares)</h4>
		
		<table class="table table-striped table-hover table-condensed small">
			<tr class="text-success">
				<td>Stock</td>
				<td>Shares Quantity</td>
				<td>Available</td>
				<td>Current price</td>
			</tr>
			@if($portfolio->count())
				@foreach($portfolio as $portf)
					<tr>
						<td>{{$portf->stock_symbol}}</td>
						<td>{{ price($portf->shares_quantity) }}</td>
						<td>{{ price($portf->shares_available_quantity) }}</td>
						<td>{{$portf->current_stock_price}}</td>
					</tr>
				@endforeach
			@else
				<tr><td colspan="4"><label class="label label-danger text-center">{{trans('no_records')}}</label></td></tr>
			@endif
		</table>
	</div>
</div>