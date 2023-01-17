<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>@yield('report_title')</title>

		<style>
			.box {
				max-width: 800px;
				margin: auto;
				padding: 8px;
				border: 1px solid #eee;
				font-size: 13px;
				line-height: 18px;
				font-family: sans-serif;
				color: #555;
                /* page-break-inside:avoid; */
			}

			.box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
                /* page-break-inside: avoid; */
			}

			.box table td {
				padding: 5px;
				vertical-align: top;
			}

			.text-right {
				text-align: right;
			}

            .fs-16 {
                font-size: 16px;
            }

			.box table tr.top table td {
				padding-bottom: 20px;
			}

			.box table tr.top table td.title {
				font-size: 24px;
				line-height: 24px;
				color: #333;
			}

			.box table tr.information table td {
				padding-bottom: 40px;
			}

			.box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

            .box table tr.heading td h2 {
				margin:5px;
			}

            .box table tr.heading td h3 {
				margin:5px;
			}

            .box table tr.heading td {
				border: none;
			}

            .box div.group {
                padding: 5px;
            }

            .bold {
                font-weight: bold;
            }

			.box table tr.details td {
				padding-bottom: 20px;
                text-align: center;
			}

			.box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			/* .box table tr.item.last td {
				border-bottom: none;
			} */

			.box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

            .box table tr.subtotal td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: normal;
			}

			@media only screen and (max-width: 600px) {
				.box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

            @media print {
                footer {page-break-after: always;}
                .page_break { page-break-after: always; }
            }

		</style>
	</head>

	<body>
		<div class="box">
            @if(empty($hideHeader))
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="100%">
						<table>
							<tr>
								<td class="title">
                                    @if(!empty($logoPdf))
									<img src="file://{{base_path('public/' . theme()->getMediaUrlPath() . 'logos/logo.png')}}" height="100"/>
                                    @else
                                    <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo.png') }}" height="100px" />
                                    @endif
								</td>

								<td class="text-right title">
                                    @yield('report_header')
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
            @endif
			@yield('content')
                
		</div>
	</body>
</html>