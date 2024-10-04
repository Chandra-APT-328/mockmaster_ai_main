const paragraphsContainer = document.querySelector('.paragraphs-container');
const paragraphs = paragraphsContainer.querySelectorAll('.drag-container');
const initialOrder = Array.from(paragraphs).map(p => p.textContent);

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.drag-container:not(.dragging)')];

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

paragraphs.forEach(paragraph => {
    paragraph.addEventListener('dragstart', function(event) {
        // event.dataTransfer.setData('text/plain', event.target.textContent);
        event.target.classList.add('dragging');
    });

    paragraph.addEventListener('dragend', function(event) {
        event.target.classList.remove('dragging');
        // paragraphs.forEach(p => p.classList.remove('drag-over'));
    });
});

paragraphs.forEach(paragraph => {
    paragraph.addEventListener('touchstart', function(event) {
        event.preventDefault();
        event.target.classList.add('dragging');
        handleTouchEnter(event.target);
    });

    paragraph.addEventListener('touchend', function(event) {
        event.preventDefault();
        event.target.classList.remove('dragging');
        handleTouchLeave(event.target);
        // paragraphs.forEach(p => p.classList.remove('drag-over'));
    });
});


paragraphsContainer.addEventListener('touchmove', function(event) {
    event.preventDefault();
    const afterElement = getDragAfterElement(paragraphsContainer, event.touches[0].clientY);
    const draggable = document.querySelector('.dragging');
    if (afterElement == null) {
        paragraphsContainer.appendChild(draggable);
    } else {
        paragraphsContainer.insertBefore(draggable, afterElement);
    }
});

function handleTouchEnter(element) {
    const dropTarget = element.closest('.drag-container');
    if (dropTarget) {
        dropTarget.classList.add('drag-over');
    }
}

function handleTouchLeave(element) {
    const dropTarget = element.closest('.drag-container');
    if (dropTarget) {
        dropTarget.classList.remove('drag-over');
    }
}


paragraphsContainer.addEventListener('dragover', function(event) {
    event.preventDefault();
    const afterElement = getDragAfterElement(paragraphsContainer, event.clientY);
    const draggable = document.querySelector('.dragging');
    if (afterElement == null) {
        paragraphsContainer.appendChild(draggable);
    } else {
        paragraphsContainer.insertBefore(draggable, afterElement);
    }
});

paragraphsContainer.addEventListener('dragenter', function(event) {
    const dropTarget = event.target.closest('.drag-container');
    if (dropTarget) {
        dropTarget.classList.add('drag-over');
    }
});

paragraphsContainer.addEventListener('dragleave', function(event) {
    const dropTarget = event.target.closest('.drag-container');
    if (dropTarget) {
        dropTarget.classList.remove('drag-over');
    }
});


document.getElementById("submitbtn").addEventListener("click", function () {
    // getting new positions
    const form = document.getElementById("ro");
    const newOrder = document.querySelectorAll('.drag-container');
    const newPositions = [];

    newOrder.forEach((paragraph, index) => {
        newPositions.push(paragraph.dataset.order);
    });
    document.getElementById("answer").value = newPositions.join();
    form.submit();
});