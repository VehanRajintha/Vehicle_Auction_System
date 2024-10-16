document.addEventListener('DOMContentLoaded', () => {
    // Add any interactive JavaScript here

    const auctionItems = document.querySelectorAll('.auction-item');

    auctionItems.forEach(item => {
        item.addEventListener('click', () => {
            const title = item.getAttribute('data-title');
            const folderName = title.replace(/\s+/g, '-').toLowerCase(); // Replace spaces with hyphens and convert to lowercase
            window.location.href = `./${folderName}/`;
        });
    });
});