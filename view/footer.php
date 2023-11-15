<div class="custom-pointer"></div>
<script>
    document.addEventListener('mousemove', (e) => {
        const customPointer = document.querySelector('.custom-pointer');
        customPointer.style.left = `${e.pageX}px`;
        customPointer.style.top = `${e.pageY}px`;
    });
</script>

<footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <p>&copy; 2023 C.B</p>
</footer>
</body>
</html>