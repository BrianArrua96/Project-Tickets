<style>
    body {
        margin: 0;
        font-family: "Nunito", sans-serif;
        display: flex;
        flex-direction: column;
    }

    .page-break {
        page-break-after: always;
    }

    .logo {
        width: 100px;
    }

    .titol-pdf {
        background-color: #000;
        color: #fff line-height: 40%;
    }

    .event-info {
        align-items: center;
    }

    .entrada-info {
        align-items: center;
    }

    .codi-qr {
        align-items: center;
    }
</style>

<body>
    <div>
        <br><br><br>
        <div class="event-info">
            <h2>Evento: {{ $event->nom }}</h2>
            <h5>{{ $event->descripcio }}</h5>
            <h4>Fecha: {{ $sessio }}</h4>
            <h4>Ubicación: {{ $lloc }}</h4>
        </div>
    </div>
    <div class="page-break"></div>
    @php
    $contador = 0;
    @endphp
    @foreach ($entrades as $entrada)
    <table>
        <tr>
            <td>
                <h3>Entrada: {{ $entrada->nom }}</h3>
                @if ($entrada->nominal)
                    <h5>Nombre Asistente: {{ $entrada->nomComprador }}</h5>
                @else
                    <h5>Nombre Comprador: {{ $entrada->nomComprador }}</h5>
                @endif
                <p>DNI/NIE: {{ $entrada->dniComprador }}</p>
                <p>Precio: {{ $entrada->precio }}€</p>
            </td>
            <td>
                <h3>Código QR:</h3>
                @php
                    $renderer = new \BaconQrCode\Renderer\ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle(400), new \BaconQrCode\Renderer\Image\SvgImageBackEnd());
                    $writer = new \BaconQrCode\Writer($renderer);
                    $svgString = $writer->writeString($entrada->numeroIdentificador);
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'qrcode') . '.svg';
                    file_put_contents($tempFilePath, $svgString);
                @endphp
                <img src="{{ $tempFilePath }}" alt="qrcode" height="100" width="100">
                <p>{{ $entrada->numeroIdentificador }}</p>
            </td>
        </tr>
    </table>
    @php
    $contador += 1;
    @endphp
    @if(!(count($entrades)) == $contador)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
