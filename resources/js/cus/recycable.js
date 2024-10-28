function filter(input_id, table_id, index) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(input_id);
    filter = input.value.toUpperCase();
    table = document.getElementById(table_id);
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[index];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterCard(input_id, container_id, class_name, index) {
    var input, filter, container, cards, cardContent, i, txtValue;
    input = document.getElementById(input_id);
    filter = input.value.toUpperCase();
    container = document.getElementById(container_id);
    cards = container.getElementsByClassName(class_name);

    for (i = 0; i < cards.length; i++) {
        cardContent = cards[i].getElementsByTagName("div")[index];
        if (cardContent) {
            txtValue = cardContent.textContent || cardContent.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
}
