<table class="tbl_price_deli">
  <thead>
    <tr>
      <th></th>
      <th colspan="2">スタンダード</th>
      <th colspan="2">プレミアム</th>
    </tr>
    <tr>
      <th rowspan="2" class="font-inbold">数量</th>
      <th colspan="2" class="font-inbold">当店からの出荷日目安</th>
      <th colspan="2" class="font-inbold">当店からの出荷日目安</th>
    </tr>
    <tr>
      <th class="font-inbold">量産のみ</th>
      <th class="font-inbold">試作込み最短</th>
      <th class="font-inbold">量産のみ</th>
      <th class="font-inbold">試作込み最短</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $row)
      <tr>
        <td>{{ $row['quantity'] }}</td>
        <td>
          <div class="tt_date" style="font-size:16px">{{ $row['production_date_s'] }}</div>
          <div class="ut_date" style="font-size:16px">{{ $row['deli_date_s'] }}日</div>
        </td>
        <td>
          <div class="tt_date" style="font-size:16px">{{ $row['production_date_sp'] }}</div>
          <div class="ut_date" style="font-size:16px">{{ $row['deli_date_sp'] }}日</div>
        </td>
        <td>
          <div class="tt_date" style="font-size:16px">{{ $row['production_date_p'] }}</div>
          <div class="ut_date" style="font-size:16px">{{ $row['deli_date_p'] }}日</div>
        </td>
        <td>
          <div class="tt_date" style="font-size:16px">{{ $row['production_date_pp'] }}</div>
          <div class="ut_date" style="font-size:16px">{{ $row['deli_date_pp'] }}日</div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
