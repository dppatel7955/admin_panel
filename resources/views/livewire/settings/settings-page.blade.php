<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 space-y-10">

        <!-- Page Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Settings</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage application configuration and security
            </p>
        </div>

        <!-- Global Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Global Settings
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">Application Name</label>
                    <input wire:model.defer="app_name" class="input" placeholder="Admin Panel">
                </div>

                <div>
                    <label class="label">Admin Email</label>
                    <input wire:model.defer="admin_email" class="input" placeholder="admin@example.com">
                </div>

                <div>
                    <label class="label">Timezone</label>
                    <input wire:model.defer="timezone" class="input" placeholder="Asia/Kolkata">
                </div>

                <div>
                    <label class="label">Currency</label>
                    <input wire:model.defer="currency" class="input" placeholder="INR">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                <button
                    wire:click="saveGlobal"
                    class="btn-primary">
                    Save Changes
                </button>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Email (SMTP) Settings
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">SMTP Host</label>
                    <input wire:model.defer="mail_host" class="input" placeholder="smtp.gmail.com">
                </div>

                <div>
                    <label class="label">SMTP Port</label>
                    <input wire:model.defer="mail_port" class="input" placeholder="587">
                </div>

                <div>
                    <label class="label">SMTP Username</label>
                    <input wire:model.defer="mail_username" class="input" placeholder="your@email.com">
                </div>

                <div>
                    <label class="label">SMTP Password</label>
                    <input wire:model.defer="mail_password" type="password" class="input" placeholder="********">
                </div>

                <div class="md:col-span-2">
                    <label class="label">Encryption</label>
                    <input wire:model.defer="mail_encryption" class="input" placeholder="tls / ssl">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <button
                    wire:click="testMail"
                    class="btn-secondary">
                    Send Test Email
                </button>

                <button
                    wire:click="saveMail"
                    class="btn-primary">
                    Save Mail Settings
                </button>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">
                    Security Settings
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">Session Timeout (minutes)</label>
                    <input wire:model.defer="session_timeout" class="input" placeholder="120">
                </div>

                <div>
                    <label class="label">Minimum Password Length</label>
                    <input wire:model.defer="password_min_length" class="input" placeholder="8">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                <button
                    wire:click="saveSecurity"
                    class="btn-primary">
                    Save Security Settings
                </button>
            </div>
        </div>

    </div>
</div>
