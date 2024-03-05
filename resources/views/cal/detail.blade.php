<ul>
    @foreach($calibrations as $calibration)
        <li>
            Calibration ID: {{ $calibration->id }}<br>
            Device Name: {{ $calibration->device_name }}<br>
            <!-- Display other values as needed -->
        </li>
    @endforeach
</ul>