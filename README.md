# Thinking in Events

## Workshop description

During the workshop we are going model and implement part of cinema domain, using events.

We will focus on service subscription model, where customers can buy electronic entrance cards. Card may be:

- created (for X visits)
- registered for customer (only once!)
- used in cinema during check-in
- automatically deactivated after X visits
- blocked by operator for some reason
- unblocked by operator

After all, we are going to answer some questions:

- How many cards are in the system?
- How many visits were performaned?
- What are the most popular cinemas and movies?
- ...

## Requirements

Workshop will be performed in Bring-Your-Own-Device formula, so you will need few things installed on your laptop:

- PHP 7.1.x (or newer) with PDO, mysql support
- MySQL with native JSON support
- composer
- git client
- your favorite IDE

Proper version of MySQL database will be also prepared and available during the workshop at AWS cloud.