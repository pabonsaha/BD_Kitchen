<table>
    <thead>
        <tr>
            <td colspan="2" align="center" style="font-size:28px">{{ generalSetting()->site_name }}</td>
        </tr>
        <tr width="600px">
            <th bgcolor="#dddddd" align="center" style="font-size:14px" width="250px">{{_trans('product.Brand').' '._trans('common.Name')}}</th>
            <th bgcolor="#dddddd" align="center" style="font-size:14px" width="250px">{{_trans('product.ID')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $brand)
            <tr>
                <td align="center" style="border-bottom:1px solid #dddddd;font-size:14px">{{ $brand->name }}</td>
                <td align="center" style="border-bottom:1px solid #dddddd;font-size:14px">{{ $brand->id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
