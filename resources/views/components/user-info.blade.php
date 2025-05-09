<form id="user-info-form" class="space-y-4">
    <textarea id="about" placeholder="About you" class="w-full border rounded p-2"></textarea>

    <input type="date" id="date_birth" class="w-full border rounded p-2">

    <select id="sex" class="w-full border rounded p-2">
        <option value="M">Male</option>
        <option value="F">Female</option>
    </select>

    <select id="nationality_id" class="w-full border rounded p-2">
        @foreach ($nationalities as $nation)
            <option value="{{ $nation->id }}">{{ $nation->name }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Info</button>
</form>

<div id="user-info-message" class="text-sm mt-2 text-green-600 hidden">Saved successfully!</div>
<script>
    document.getElementById('user-info-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const token = localStorage.getItem('token');
        if (!token) return alert("Login first.");

        const payload = {
            about: document.getElementById('about').value,
            date_birth: document.getElementById('date_birth').value,
            sex: document.getElementById('sex').value,
            nationality_id: document.getElementById('nationality_id').value,
        };

        fetch('/api/user-info', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    document.getElementById('user-info-message').classList.remove('hidden');
                } else {
                    console.error(data.errors || data.message);
                }
            })
            .catch(err => console.error(err));
    });
</script>

