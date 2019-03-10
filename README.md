
Polly
=====

### What is Polly?
Polly is an online messaging software that works through queues, it aims to help you not to loose concentration on the person you're chatting with.

#### How it works?
It's based off a bunch of dependencies, but don't worry, they're all met right off the source.

#### Features
 - Fast and easy to use UI.
 - Modern and fully responsive "Material" design.
 - Totally customizable.
 - Low server resource footprint.
 - Easy to set up.
 - Minimal amount of dynamic resources (less client/server bandwidth usage).
 - Custom API: **works through JSON and plain text!**
 - Excellent security level, including data escaping and multiple authorization checks.

#### Dependencies
##### Backend
 - Apache
 - MariaDB / MySQL
 - PHP

##### Frontend
 - MaterializeCSS (framework)
 - jQuery (full, Ajax)
 - Polly API

##### Licensing
Polly and all its modules (with exception of their dependencies) are licensed under the [MIT license](LICENSE).

#### TODO
- [ ] Add the required methods to insert and remove contacts to the API.
- [ ] Create a modal and a whole page to manage the contacts in the *front end* (CRUD).
- [ ] Run several security auditories to test the API access checks.
- [ ] Rewrite several API cases which are running off two or more SQL queries, causing bigger resource footprints.
- [ ] Improve the behavior of the modal in the index (*Home*) so that it implements the new status badge (available/busy).
- [ ] Add the ability of running "dangerous" or DB-level SQL queries through a custom access token, as well as running these cases in the *back end* right off the API.
- [ ] Provide a safe way to determine whether the user wants to chat with the person that's contacting it or not.
- [ ] Run manual tests to ensure that `notifyMessageReceived` will **never** be executed before the client reports that `getLastMessage` passed.
- [ ] Write a comprehensive guide as well as a full documentation for the API cases, permission, levels and more.
- [ ] Add an installer that allows both the database, the tables, and the setup required for them, to be done in a 1-click fashion.
- [ ] Add a custom output value to refer a state as `chat session ended` and safely handle it on both clients. Make sure that these changes are non-blocking in the *front end* without messing with the security (i.e.: prevent the user to send any other message once this stage is reached).
- [ ] Prevent messages getting unsent due to an overflow for the type "string" if a client ever manages to send more than 65535 characters. Add a table for subs and match them with the private message id (`id`) in the `polly_messages`, this could let the length extend infinitely as soon as the resources are enough (**handle this as a limit too**).
