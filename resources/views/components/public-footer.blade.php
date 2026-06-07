<footer class="bg-surface-container-high border-t border-outline-variant mt-auto pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-8 mb-12">
            
            <!-- Info Kolom Kiri -->
            <div class="md:col-span-5 lg:col-span-6">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-primary text-on-primary rounded-2xl flex items-center justify-center font-bold text-2xl shadow-md shrink-0">
                        S
                    </div>
                    <div>
                        <h2 class="font-extrabold text-2xl tracking-tight text-on-surface mb-1">SIKAP</h2>
                        <p class="text-sm font-semibold text-on-surface-variant leading-tight">Sistem Informasi Kepuasan dan Evaluasi Layanan Aplikasi</p>
                        <p class="text-[10px] uppercase tracking-widest text-primary font-bold mt-2">Diskominfo Kota Batam</p>
                        
                        <p class="text-on-surface-variant mt-6 mb-6 text-sm leading-relaxed max-w-md">
                            Platform resmi untuk menampung suara, kritik, dan saran masyarakat guna mewujudkan layanan publik Kota Batam yang prima dan responsif.
                        </p>
                        <div class="flex items-start gap-3 text-sm text-on-surface-variant">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-primary mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <p>
                                Kantor Walikota Batam Lt. 7<br>
                                Jl. Engku Putri No.1, Batam Centre<br>
                                Kota Batam, Kepulauan Riau 29432
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tautan Cepat -->
            <div class="md:col-span-3 lg:col-span-3">
                <h3 class="font-bold text-on-surface mb-6 uppercase tracking-wider text-sm">Tautan Cepat</h3>
                <ul class="space-y-4 text-sm text-on-surface-variant">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary/50"></span> Beranda</a></li>
                    <li><a href="{{ route('surveys.index') }}" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-primary/50"></span> Daftar Survei</a></li>
                </ul>
            </div>

            <!-- Kontak & Dukungan -->
            <div class="md:col-span-4 lg:col-span-3">
                <h3 class="font-bold text-on-surface mb-6 uppercase tracking-wider text-sm">Hubungi Kami</h3>
                <ul class="space-y-4 text-sm text-on-surface-variant">
                    <li class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        kominfo@batam.go.id
                    </li>
                    <li class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        +62 778 8073194
                    </li>
                </ul>
                
            </div>

        </div>

        <!-- Bottom Bar / Copyright -->
        <div class="pt-8 border-t border-outline-variant/60 flex flex-col justify-center items-center gap-4 text-sm text-on-surface-variant">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Batam. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>
