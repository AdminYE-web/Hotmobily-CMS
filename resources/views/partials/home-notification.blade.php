@if ($notification->is_active && trim((string) $notification->message) !== '')
    <style>
        .home-notification {
            margin: 0 0 10px;
            background-color: #fff;
            border: 2px solid #900;
            font-family: "IwaUDGoDspPro-Th", sans-serif;
        }

        .home-notification summary {
            margin: 12px 5px;
            color: red;
            font-size: 15px;
            font-weight: 700;
            line-height: 20px;
            letter-spacing: .05em;
            text-align: center;
            cursor: pointer;
            list-style: none;
        }

        .home-notification summary::-webkit-details-marker { display: none; }
        .home-notification-message {
            padding: 0 10px 10px;
            font-size: 13px;
        }
        .home-notification-message > :last-child { margin-bottom: 0; }
    </style>

    <details class="home-notification">
        <summary>{{ $notification->title }}</summary>
        <div class="home-notification-message">{!! $notification->message !!}</div>
    </details>
@endif
