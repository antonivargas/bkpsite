Automatic Actions
=================

To minimize the user interaction, Kanboard support automatic actions.

Each automatic action is defined like that:

- An event to listen
- An action linked to this event
- Eventually there is some parameters to define according to the chosen action

Each project can have a different set of automatic actions, the configuration panel is located on the project listing page, just click on the link "Automatic actions".

To add a new automatic action, choose the event with an action and click on the button "Next Step", then specify action parameters and finish the process by clicking on the button "Save this action".

Each time an event occurs, the corresponding actions are executed.

List of available events
------------------------

- Move a task to another column
- Move a task to another position in the same column
- Task modification
- Task creation
- Open a closed task
- Closing a task

List of available actions
-------------------------

- Close the task
- Assign the task to a specific user
- Assign the task to the person who does the action
- Duplicate the task to another project
- Assign a color to a specific user

Examples
--------

Here are some examples used in the real life:

### When I move a task to the column "Done", automatically close this task

- Choose the event: **Move a task to another column**
- Choose the action: **Close the task**
- Define the action parameter: **Column = Done** (this is the destination column)

### When I move a task to the column "To be validated", assign this task to a specific user

- Choose the event: **Move a task to another column**
- Choose the action: **Assign the task to a specific user**
- Define the action parameters: **Column = To be validated** and **User = Bob** (Bob is our tester)

### When I move a task to the column "Work in progress", assign this task to the current user

- Choose the event: **Move a task to another column**
- Choose the action: **Assign the task to the person who does the action**
- Define the action parameter: **Column = Work in progress**

### When a task is completed, duplicate this task to another project

Let's say we have two projects "Customer orders" and "Production", once the order is validated, swap it to the "Production" project.

- Choose the event: **Closing a task**
- Choose the action: **Duplicate the task to another project**
- Define the action parameters: **Column = Validated** and **Project = Production**

### When I create a new task in the column "To do", assign a specific color to the user Bob

- Choose the event: **Task creation**
- Choose the action: **Assign a color to a specific user**
- Define the action parameters: **Column = To do**, **Color = Green** and **Assignee = Bob**
