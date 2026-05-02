document.addEventListener('DOMContentLoaded', function () {
   const selects = document.querySelectorAll('.colorSelect');
   const radios = document.querySelectorAll('.activeRadio');
   const coordCells = document.querySelectorAll('.coordCell');
   const gridCells = document.querySelectorAll('.gridCell');
   const messageDiv = document.getElementById('message');

   window.cellMap = {};
   const cellMap = window.cellMap;

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
            delete cellMap[coord];
            this.style.backgroundColor = '';
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
      
      // group by COLOR (not rowIndex)
      Object.keys(cellMap).forEach((coord) => {
         let color = cellMap[coord].color;
      
         if (!grouped[color]) grouped[color] = [];
         grouped[color].push(coord);
      });
   
      // map each color row in the UI to its coordinates
      selects.forEach((select, index) => {
         let color = select.value;
      
         if (grouped[color]) {
            let coords = grouped[color];
         
            // sort properly (A1, B2, etc.)
            coords.sort((a, b) => {
               let colA = a[0], colB = b[0];
               let rowA = parseInt(a.slice(1));
               let rowB = parseInt(b.slice(1));
            
               if (colA === colB) return rowA - rowB;
               return colA.localeCompare(colB);
            });
         
            coordCells[index].textContent = coords.join(', ');
         }
      });
   }

   window.prepareData = function () {
      console.log("SUBMIT FIRED");
      console.log(window.cellMap);

      document.getElementById("gridData").value =
         JSON.stringify(window.cellMap);
   };
});

