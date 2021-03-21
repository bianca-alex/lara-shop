<?php

return [
    'alipay' => [
        'app_id' => '2016100200645839',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmv0K43gun5cktIxtEqXaLIp5hC8ujBhYPYYA/yGeIDkC2Jb+yhtFusxiAxbHZNwHaaa0pDs4lmmiKjvHERea9gjkFULhTCkw66EuByh/qpNrUDfU8+r9Ytvxy1asdUsYr1ZNj31RSdngRoHQf/YP5ix0ULrwumWUHwuqn2C0Z06i18QAsHrBNcsf0qHHnhvkgyh67x6OKxDOCFtyGrbm53N670Z1d0M97Yyu2zlkzV2In3NQ8JmRMrxQh9UHGnOjsWRS0WLPvESvu1qGo2Y+tUOSdvMM9BDuf2oNqHo8vbnJnOvlZMm+2poahN1SL+t+aoZDbf+b4IagfZ9U/i8k9wIDAQAB',
        'private_key' => 'MIIEpQIBAAKCAQEAtLZClpw+x5WbHVvv60bKcrsyThTDV+sWJ+sdoDJeIRKywwJ9I0TfzMN8ObcufPUlaFXLPNUqJ8iV4l5RX4R0Zs9uEBw+JJh7/O25UPrxjRnwtMxL9+mkKHXwPAjRgMcJqGenUUb3GzSpDG+THg93cBqk2qDMtC6UShvNvl0G4lG0YZDWNLAIXDNLfmHhvho1okHGlexBsVQFD0gQc1Har/zM1kViXBEzDr4rLC+pLLndTrmDsYQ8HaysaogoSb3I/OvZN9fqjyLIo1omQRUN10AWK6JF6PuAhiJlD43P5JT6SGXH2nrxOAC0ilm5Obiniq2W/CWOIe/Otj6+Qi8frwIDAQABAoIBAQCK3OMeSMIVK+keDl+2M5etwhtN1LanAIbt9cW2K/4Y+/1RzL/MMkinWDBFSXX3n4k3O3YJMORL3d8PK9rrwySPPCYfSxSVmnbsTOByUeL7wkstIy/dOTRjwvzvpPcYNdo+BiiUVCveRAEDBVnPZ6MoCdFUDuw+KOzaZbMb7PA1R7jsotn8BG5fpwljD49IH21XXIQf5vd6tft5zeFlLOhj7Q4xi95SvFsCGJcWDtpqECAx2xC2W3OLmoxuwfn4v5KXeTTil5TtPXpB5o4v8okZSLDNeLoMu4WIG0pVUtLZjpxPI8XUWLmOYVerZ1H87k4uVQRkNVO3itV1Dfj6v6WBAoGBANtru41fM5EK+MmGyD73cHtHj2iZVFwxkkP6Tt82WFz/5MnKvm+d0eLv71ZLfla5merlkNnK1hVfnPMw3wx0hzqq98iuhrpwFyfPZpgOmsnaS2xAbtTRcwH11JEGT+VNIks6u7VCw746H+ENXd/b+rBmg0NShkUo9ZuOUBqE85j5AoGBANLWinbAwQTRgYxJNuJMv9K4WAcO9Y5hoqctkfZ1Y3toAPvF0CZbXyq24oyUC6Q6DkkvO3BZiz/MWGVIEJpgFW+UoNZc7TCVszhl0guU7eCJkuOihVkSDjJVvTQMWNZRKurDpk5VB11pgnKN3aWI2QivmM5EmJ2ywKFdWfhnlY/nAoGBALY9pGimyY2OL1QyPd8OZL3/kXyu3QI1qeYL37ZEzN9xKfTwD3tk+Q4jegWSbjxZqx0NzmEVtvnJj/HshVUy854moeZsDjqLHrBR8kQY3TcJt9sRKPxZecwHAaXyOCmbBwC0p3LFIQ699/xTvcRQUMZyXlNsF1kZy+SHLsDX6/sBAoGBAJYxWwXpnhauoFitNznSbrvPsnWkxGyfRN1O6zHkwe+BUWIJspQAdzTYf16hgAGHkfG0geUxBK94BGhyA9HVLLAF8uWB4T3BBqDgd9bkSuivWEJs3g1rfU2CInxXZ1mVDLuckHYwwERdCx5LzV9Es0cqv/IAj6+XTP4moBcCw1p1AoGAXF4qF+fkD+yWv2nB0E6ir5xUM26dZUtLONG2gmc57APRWtcWRSe5lFfF6/vs2eArZMJ92yCUY4gwbDUqrIoSlIR2LbDcQInLqXxXhgOz8+Y0o3OHyF8HzQWBYoqSwCab2VmJoqvyhiOH7/j82i2DUC0oEoiL53opBnXIbb4gA7Y=',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
