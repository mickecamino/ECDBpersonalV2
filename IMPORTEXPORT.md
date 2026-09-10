# Import / Export
I have added a *BETA* Import/Export routine.

The *Export components* button extract all components from the database and export it as a CSV-file in the following format:

```
id;owner;name;manufacturer;package;pins;quantity;order_quantity;location;scrap;datasheet;comment;category;cimage;appnote;price
732;1801;"MM 74C917N";;DIP;28;2;0;;No;mm74c917n.pdf;"6-digit hex display controller and driver";502;dip28.jpg;;0
733;1801;"MM 74C926N";;DIP;18;2;0;;No;;"4-digit decade counter/display driver, carry out and latch (up to 9999)";502;;;0
734;1801;"MM 74C928N";;DIP;18;4;0;;No;;"4-digit counter/display driver (up to 1999)";502;;;0
735;1801;"MM 5313N";NS;DIP;28;1;0;;No;mm5309-15.pdf;"Digital Clock";599;;;0
```

The upload routine can either **add**, **edit** or **delete** components:

# The format of the CSV-file is:
## Add components
The first field is an *action* field, for adding components the action is **add**.  
Mandatory fields are: name, category and scrap ("No" or "Yes"). Set pins, quantity and order_quantity to 0 (zero). The rest can be empty.
```
action;name;manufacturer;package;pins;quantity;order_quantity;location;scrap;datasheet;comment;category;cimage;appnote;price
add;74LS00;;DIP;14;0;0;;No;;Quad 2-input NAND gate;cat;;;;
add;74LS04;;DIP;14;0;0;;No;;Hex inverter;cat;;;;
add;74LS07;;DIP;14;0;0;;No;;Hex buffer;cat;;;;
add;74LS08;;DIP;14;0;0;;No;;Quad 2-input AND gate;cat;;;;
add;74LS138;;DIP;16;0;0;;No;;3-to-8-line decoder;cat;;;;
add;74LS156N;;DIP;16;0;0;;No;;dual 2-to-4-line decoder;cat;;;;
```
## Edit components
The first field is an **action** field, for edit components the action is **edit**.  
Mandatory fields are: name and id, the rest is from your export with the changes that you will make. This example is updating the Quantity.  
```
action;id,name;manufacturer;package;pins;quantity;order_quantity;location;scrap;datasheet;comment;category;cimage;appnote;price
edit;854;74LS00;;DIP;14;4;0;;No;;Quad 2-input NAND gate;cat;;;;
edit;855;74LS04;;DIP;14;8;0;;No;;Hex inverter;cat;;;;
edit;856;74LS07;;DIP;14;12;0;;No;;Hex buffer;cat;;;;
edit;857;74LS08;;DIP;14;25;0;;No;;Quad 2-input AND gate;cat;;;;
edit;858;74LS138;;DIP;16;2;0;;No;;3-to-8-line decoder;cat;;;;
edit;859;74LS156N;;DIP;16;9;0;;No;;dual 2-to-4-line decoder;cat;;;;
```
## Delete components
The first field is an **action** field, for deleting components the action is **delete**.  
Mandatory fields are: name and id.
```
action;id
delete;854
delete;855
delete;856
delete;857
delete;858
delete;859
``` 