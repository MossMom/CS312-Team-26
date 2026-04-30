document.addEventListener('DOMContentLoaded', function () {
   const selects = document.querySelectorAll('.colorSelect');
   const radios = document.querySelectorAll('.activeRadio');
   const coordCells = document.querySelectorAll('.coordCell');
   const gridCells = document.querySelectorAll('.gridCell');
   const messageDiv = document.getElementById('message');

   let cellMap = {};

   // Store previous dropdown values
   selects.forEach((select) => {
      select.dataset.prev = select.value;

      select.addEventListener('focus', function () {
         this.dataset.prev = this.value;
      });
   });

   // Prevent duplicate colors
   selects.forEach((select, index) => {
      select.addEventListener('change', function () {
         let usedColors = [];

         selects.forEach((s, i) => {
            if (i !== index) usedColors.push(s.value);
         });

         if (usedColors.includes(this.value)) {
            this.value = this.dataset.prev;
            messageDiv.textContent =
               'This color is already in use. Please choose another.';
            return;
         }

         const oldColor = this.dataset.prev;
         const newColor = this.value;

         this.dataset.prev = newColor;
         messageDiv.textContent = '';

         // Recolor, row ownership updated
         Object.keys(cellMap).forEach((coord) => {
            if (cellMap[coord].color === oldColor) {
               cellMap[coord].color = newColor;
               cellMap[coord].rowIndex = index;

               const cell = document.querySelector(`[data-coord='${coord}']`);
               cell.style.backgroundColor = newColor.toLowerCase();
            }
         });

         updateCoordinates();
      });
   });

   // Paint grid cells
   gridCells.forEach((cell) => {
      cell.addEventListener('click', function () {
         const coord = this.dataset.coord;

         let activeIndex = [...radios].findIndex((r) => r.checked);
         let activeColor = selects[activeIndex].value;

         // If cell already painted, overwrite with the new color
         if (cellMap[coord]) {
            // remove old color
            delete cellMap[coord];
         }

         // Paint
         this.style.backgroundColor = activeColor.toLowerCase();

         // Save new mapping
         cellMap[coord] = {
            color: activeColor,
            rowIndex: activeIndex,
         };

         updateCoordinates();
      });
   });

   // Update coordinate lists
   function updateCoordinates() {
      coordCells.forEach((cell) => (cell.textContent = ''));

      let grouped = {};

      Object.keys(cellMap).forEach((coord) => {
         let row = cellMap[coord].rowIndex;

         if (!grouped[row]) grouped[row] = [];
         grouped[row].push(coord);
      });

      Object.keys(grouped).forEach((row) => {
         let coords = grouped[row];
         // Keep the clicked cell coordinates in sorted order
         coords.sort((a, b) => {
            let colA = a[0],
               colB = b[0];
            let rowA = parseInt(a.slice(1));
            let rowB = parseInt(b.slice(1));

            if (colA === colB) return rowA - rowB;
            return colA.localeCompare(colB);
         });

         coordCells[row].textContent = coords.join(', ');
      });
   }
});
