<footer class="bg-white rounded shadow p-5 mb-4 mt-4">
            <div class="row">
                <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
                    <p class="mb-0 text-center text-lg-start">© 2019-<span class="current-year"></span> <a
                            class="text-primary fw-normal" href="https://themesberg.com"
                            target="_blank">Themesberg</a>
                    </p>
                </div>
                <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
                    <!-- List -->
                    <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
                        <li class="list-inline-item px-0 px-sm-2">
                            <a href="https://themesberg.com/about">About</a>
                        </li>
                        <li class="list-inline-item px-0 px-sm-2">
                            <a href="https://themesberg.com/themes">Themes</a>
                        </li>
                        <li class="list-inline-item px-0 px-sm-2">
                            <a href="https://themesberg.com/blog">Blog</a>
                        </li>
                        <li class="list-inline-item px-0 px-sm-2">
                            <a href="https://themesberg.com/contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-pelanggan" class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">#</th>
                                    <th class="border-0">First Name</th>
                                    <th class="border-0">Last Name</th>
                                    <th class="border-0">Birthday</th>
                                    <th class="border-0">Gender</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Phone</th>
                                    <th class="border-0 rounded-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <table id="table-pelanggan" class="table table-centered table-nowrap mb-0 rounded">
                                    <thead class="thead-light">
                                        ...
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach ($dataPelanggan as $row)
                                            <tr>
                                                <td>{{ ++$no }}</td>
                                                <td>{{ $row->first_name }}</td>
                                                <td>{{ $row->last_name }}</td>
                                                <td>{{ $row->gender }}</td>
                                                <td>{{ $row->birthday }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td><a href="{{ route('pelanggan.edit', $row->pelanggan_id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <svg class="icon icon-xs me-2" data-slot="icon"
                                                            fill="none" stroke-width="1.5" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                            </path>
                                                        </svg>
                                                        Edit
                                                    </a><a href="{{ route('pelanggan.destroy', $row->pelanggan_id) }}"
                                                        class="btn btn-danger btn-sm">
                                                        <svg class="icon icon-xs me-2" data-slot="icon"
                                                            fill="none" stroke-width="1.5" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </footer>