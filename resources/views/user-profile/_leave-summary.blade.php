<div class="card-panel">

    <div>
        <h4 class="title-color"><span>Leave Summary</span></h4>


        <div style="text-align:center;">

             <table class="display striped">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th>Leave Name</th>
                        <th>Total Leaves</th>
                        <th>Used Leaves</th>
                        <th>Remaining Leaves</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaves_master as $key=>$leave)
                    <tr>
                        <th style="width: 5%">{{++$key}}</td>
                        <td>{{$leave->Name}}</td>
                        <td>{{$leave->Number}}</td>
                        @if(!isset($sum[$key]))
                        <?php $sum[$key] = 0 ?>
                        <td>{{$sum[$key]}}</td>
                        @else
                        <td>{{$sum[$key]}}</td>
                        @endif
                        <td>{{$leave->Number-$sum[$key]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>