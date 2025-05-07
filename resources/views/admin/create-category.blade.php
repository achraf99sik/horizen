@extends('layouts.app')

@section('title', "Categories")

@section('content')

        <form action="{{ route('categories.store') }}" id="categoryForm">
            <input type="text" name="name" id="categoryName">
            <button type="submit">create</button>
        </form>
        <h2 class="text-xl font-bold mb-4">Cotegoies (<span id="Categories_count"></span>)</h2>
        <div id="Categories-list" class="space-y-4"></div>
        <x-loading loadingId="Categories-loading"/>
    <script>

        let categoryPage = 1;
        let loadingCategories = false;
        let categoryEndReached = false;
        function formatcategory(category, depth = 0) {
            let marginLeft = depth * 20;
            let html = `
                <div class="bg-twitch-bg-header p-3 rounded" style="margin-left: ${marginLeft}px">
                    <p class="text-base text-white">${category.name}</p>
                    <p class="text-xs text-gray-400">${new Date(category.created_at).toLocaleDateString()}</p>
                </div>
            `;

            if (category.replies && category.replies.length > 0) {
                category.replies.forEach(reply => {
                    html += formatcategory(reply, depth + 1);
                });
            }

            return html;
        }

        function loadCategories(reset = false) {
            if (loadingCategories || (categoryEndReached && !reset)) return;

            loadingCategories = true;
            document.getElementById('Categories-loading').style.display = 'block';

            if (reset) {
                categoryPage = 1;
                categoryEndReached = false;
                document.getElementById('Categories-list').innerHTML = '';
            }

            fetch(`/api/categories?page=${categoryPage}`)
                .then(res => res.json())
                .then(data => {
                    if (data.data.length === 0 && !reset) {
                        categoryEndReached = true;
                    }
                    document.getElementById("Categories_count").innerText = `${data.category_count}`;

                    data.data.forEach(category => {
                        document.getElementById('Categories-list').innerHTML += formatcategory(category);
                    });

                    if (categoryPage < data.total_pages) {
                        categoryPage++;
                        loadingCategories = false;
                    }

                    document.getElementById('Categories-loading').style.display = 'none';
                });
        }

        window.addEventListener('scroll', () => {
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 500;
            if (nearBottom) {
                loadCategories();
            }
        });
        loadCategories();

        document.getElementById('categoryForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const token = localStorage.getItem('token');

                if (!token) {
                    alert("You must be logged in to create category.");
                    return;
                }

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        loadCategories(true);
                        alert("created successful!");
                    } else {
                        console.error(result);
                        alert("category creating failed: " + (result.message || 'Unknown error'));
                    }

                } catch (error) {
                    console.error(error);
                    alert("An error occurred while creating.");
                }
            });
    </script>
@endsection
