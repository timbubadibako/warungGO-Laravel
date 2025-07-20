<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-green-50">
        <x-slot name="headerCenter">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-green-600 rounded-xl flex items-center justify-center">
                    <x-lucide-user class="w-5 h-5 text-white" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Profil & Akun</h2>
                    <p class="text-sm text-gray-600">Kelola informasi dan keamanan akun</p>
                </div>
            </div>
        </x-slot>

        <div class="p-6 space-y-6">
            <!-- Profile Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl flex items-center justify-center shadow">
                        <span class="text-white text-2xl font-bold">{{ strtoupper(substr($user->name,0,1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-1">Halo, {{ $user->name }}</h1>
                        <p class="text-gray-600 text-base md:text-lg">Selamat datang di halaman pengaturan akun dan manajemen pengguna.</p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $user->roles->pluck('name')->implode(', ') }}
                    </span>
                </div>
            </div>
            <!-- Success Messages -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <x-lucide-check-circle class="w-5 h-5 text-green-600 mr-3" />
                        <span class="text-green-800 font-medium">
                            @if(session('status') == 'profile-updated')
                                Profil berhasil diperbarui!
                            @elseif(session('status') == 'password-updated')
                                Password berhasil diubah!
                            @elseif(session('status') == 'user-created')
                                User baru berhasil dibuat!
                            @elseif(session('status') == 'user-updated')
                                Data user berhasil diperbarui!
                            @elseif(session('status') == 'user-deleted')
                                User berhasil dihapus!
                            @else
                                {{ session('status') }}
                            @endif
                        </span>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <x-lucide-alert-circle class="w-5 h-5 text-red-600 mr-3 mt-0.5" />
                        <div>
                            <h4 class="text-red-800 font-medium mb-2">Terjadi kesalahan:</h4>
                            <ul class="text-red-700 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Profile Information Card -->
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                    <div class="p-6 border-b border-gray-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <x-lucide-user-circle class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Informasi Profil</h3>
                                <p class="text-sm text-gray-600">Perbarui informasi profil dan email Anda</p>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-4">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <p class="text-amber-800 text-sm">
                                    Email Anda belum diverifikasi.
                                    <button form="send-verification" class="underline text-amber-600 hover:text-amber-800 font-medium ml-1">
                                        Klik di sini untuk mengirim ulang email verifikasi.
                                    </button>
                                </p>
                            </div>
                        @endif

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all transform hover:scale-105">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                    <div class="p-6 border-b border-gray-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                <x-lucide-lock class="w-5 h-5 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Ubah Password</h3>
                                <p class="text-sm text-gray-600">Pastikan akun Anda menggunakan password yang kuat</p>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white font-medium py-3 px-6 rounded-xl hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- User Management Card (Admin Only) -->
                @hasrole('Admin')
                <div class="lg:col-span-2">
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                        <div class="p-6 border-b border-gray-200/50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <x-lucide-users class="w-5 h-5 text-white" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">Manajemen Pengguna</h3>
                                        <p class="text-sm text-gray-600">Kelola semua pengguna sistem</p>
                                    </div>
                                </div>
                                <button onclick="toggleAddUserForm()" class="bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium py-2 px-4 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all transform hover:scale-105">
                                    <x-lucide-plus class="w-4 h-4 inline mr-2" />
                                    Tambah User
                                </button>
                            </div>
                        </div>

                        <!-- Add New User Form (Hidden by default) -->
                        <div id="addUserForm" class="hidden p-6 border-b border-gray-200/50 bg-purple-50/50">
                            <form method="post" action="{{ route('profile.users.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                    <input name="name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input name="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input name="password" type="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                    <input name="password_confirmation" type="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium py-3 px-6 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all">
                                        Buat User
                                    </button>
                                    <button type="button" onclick="toggleAddUserForm()" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-xl hover:bg-gray-200 transition-all">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Users List -->
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($users as $userData)
                                    <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-gray-400 to-gray-500 rounded-xl flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ substr($userData->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $userData->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $userData->email }}</p>
                                                <div class="flex space-x-2 mt-1">
                                                    @foreach($userData->roles as $role)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($userData->id !== auth()->id())
                                                <button onclick="editUser({{ $userData->id }}, '{{ $userData->name }}', '{{ $userData->email }}', '{{ $userData->roles->first()->name ?? '' }}')"
                                                    class="text-blue-600 hover:text-blue-800 transition-colors">
                                                    <x-lucide-edit class="w-4 h-4" />
                                                </button>
                                                <form method="post" action="{{ route('profile.users.destroy', $userData) }}" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus user {{ $userData->name }}?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                                        <x-lucide-trash-2 class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endhasrole
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Edit User</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            <form id="editUserForm" method="post" class="space-y-4">
                @csrf
                @method('patch')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input id="editName" name="name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="editEmail" name="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Opsional)</label>
                    <input name="password" type="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="editRole" name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @hasrole('Admin')
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        @endhasrole
                    </select>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-red-800">Konfirmasi Hapus Akun</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            <div class="mb-4">
                <p class="text-gray-600 mb-4">Setelah akun Anda dihapus, semua resource dan data akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi penghapusan akun.</p>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all">
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium py-3 px-6 rounded-xl hover:from-red-700 hover:to-red-800 transition-all">
                        Ya, Hapus Akun
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-6 rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    @endif

    <script>
        function toggleAddUserForm() {
            const form = document.getElementById('addUserForm');
            form.classList.toggle('hidden');
        }

        function editUser(id, name, email, role) {
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editUserForm').action = `/profile/users/${id}`;
            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Close modals when clicking outside
        document.getElementById('editUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
