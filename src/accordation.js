
    function setupAccordion(buttonId, contentId, iconId) {
        document.getElementById(buttonId).addEventListener('click', function() {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    }

    // Initialize the first accordion
    setupAccordion('accordion-button', 'accordion-content', 'accordion-icon');

    // Initialize the second accordion
    setupAccordion('accordion-button-2', 'accordion-content-2', 'accordion-icon-2');



   