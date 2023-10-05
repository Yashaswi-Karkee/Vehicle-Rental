<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg max-w-md w-full">
            <a href="{{ route('show.order.history') }}"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 cursor-pointer">
                <!-- Use Font Awesome icon class for close icon -->
                <i class="fas fa-times text-2xl"></i>
            </a>
            @if (Session::has('success'))
                <div role="alert" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3">
                    {{ Session::get('success') }}</div>
            @endif
            @if (Session::has('fail'))
                <div role="alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ Session::get('fail') }}</div>
            @endif
            <h2 class="text-2xl font-semibold text-center mb-4">Write a Review</h2>
            <div class="flex justify-center space-x-2 mb-4 text-3xl cursor-pointer">
                <span class="star" onclick="setRating(1)">&#9733;</span>
                <span class="star" onclick="setRating(2)">&#9733;</span>
                <span class="star" onclick="setRating(3)">&#9733;</span>
                <span class="star" onclick="setRating(4)">&#9733;</span>
                <span class="star" onclick="setRating(5)">&#9733;</span>
            </div>
            <form action="{{ route('post.review', $id) }}" method="POST">
                @csrf
                <input type="number" id="ratings" name="rating" hidden required />
                <textarea id="review-text" class="w-full h-32 px-3 py-2 border border-gray-300 rounded"
                    placeholder="Write your review here" name="description" required></textarea>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white text-center font-bold py-2 px-4 rounded mt-4">
                    Submit Review</button>
            </form>
        </div>
    </div>

</body>

<script type="text/javascript">
    const ratingVal = document.getElementById('ratings');
    ratingVal.value = 0;

    // Function to set the star rating
    function setRating(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-yellow-500');
            } else {
                star.classList.remove('text-yellow-500');
            }
        });
        ratingVal.value = document.querySelectorAll('.star.text-yellow-500').length;

    }
</script>

</html>
