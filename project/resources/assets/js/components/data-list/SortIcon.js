class SortIcon {
    constructor() {
        this.order = '';
    }

    getArrowUpClass() {
        return 'fas fa-sort-up ml-2';
    }

    getArrowDownClass() {
        return 'fas fa-sort-down ml-2';
    }

    getSortClass() {
        return 'fas fa-sort ml-2';
    }

    getArrowClass() {
        return this.order === 'asc' ?
            this.getArrowUpClass() :
            this.getArrowDownClass();
    }

    getFaElement() {
        let arrow = document.createElement('i');
        arrow.className = this.getSortClass();

        return arrow;
    }

    getAllIcons() {
        return document.querySelectorAll('th[sortable]');
    }

    setArrow() {
        this.getAllIcons().forEach((node) => {
            node.classList.add('cursor-pointer');
            node.appendChild(this.getFaElement());
        });
    }

    setToggleOrder() {
        this.order = (this.order === 'asc') ? 'desc' : 'asc';
    }

    updateSortClass(element, arrowClass) {
        const i = element.childNodes[1];
        if (i != undefined) {
            i.className = arrowClass;
        }
    }

    updateAllSortClass() {
        this.getAllIcons().forEach((node) => {
            this.updateSortClass(node, this.getSortClass());
        });
    }

    change(event) {
        this.updateAllSortClass();
        this.setToggleOrder();
        this.updateSortClass(event.target, this.getArrowClass());
    }
}

export default SortIcon;
