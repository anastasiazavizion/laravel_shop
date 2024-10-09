<h1>Shop</h1>

<p>This is a SPA - a website-shop with products, the ability to make an order and pay via Paypal,and an admin panel for admin users.</p>

<h2>Features</h2>
<ul>
    <li><strong>User Authentication</strong>: Secure sign-up and login: default login, via Google</li>
    <li><strong>List all products</strong>: there is a pagination, an ability to filter products by category, fulltext search by title and description (use Scout and Algolia)</li>
    <li><strong>Product page</strong>: general product info, rate and comments</li>
    <li><strong>Cart and checkout page</strong>: user can pay via Paypal</li>
    <li><strong>Generate invoice for order</strong>: use LaravelDaily/laravel-invoices</li>
    <li><strong>Products wishlist</strong>: the ability to subscribe to price or availability changes</li>
    <li><strong>Mail notifications:</strong> send email after creating and order and when trigger products changes from wishlist</li>
    <li><strong>Roles and permissions system</strong></li>
    <li><strong>Admin panel:</strong> admin can manage products and categories, view orders and statistic. Also admin can see a Google map with all customers adresses</li>
    <li><strong>Google autocomplete:</strong> when user fill in a form for complete an order the user can use Google autocomplete for select a necessary address</li>
    <li><strong>Telegram bot for admin</strong>: when there is a new order admin will have a notification in the telegram bot</li>
</ul>

<h2>Technologies Used</h2>
<ul>
    <li><strong>Frontend</strong>: Vue.js, Vuex, HTML, CSS, Tailwind CSS, SASS</li>
    <li><strong>Backend</strong>: PHP, Laravel</li>
    <li><strong>Database</strong>: MySQL/PostgreSQL</li>
    <li><strong>Caching, Queue</strong>: Redis</li>
    <li><strong>Cloud Storage</strong>: AWS S3</li>
    <li><strong>Real-time Communication</strong>: Pusher</li>
    <li><strong>Libraries</strong>: Chart.js</li>
    <li><strong>Packages</strong>: Sanctum, Scout(Algolia)</li>
    <li><strong>Notifications:</strong> Email (Gmail server, Telegram)</li>
</ul>

<h2>Getting Started</h2>
<p>To get started with the project:</p>
<ul>
    <li>Clone the repository:
        <pre><code>git clone git@github.com:anastasiazavizion/laravel_shop.git</code></pre>
    </li>
    <li>Make sure Docker is installed on your machine.</li>
    <li>Navigate to the project directory:
        <pre><code>cd laravel_shop </code></pre>
    </li>
    <li>Set up your .env file:
        <pre><code>cp .env.example .env</code></pre>
    </li>
    <li>Configure necessary keys in your .env file.</li>
    <li>Install dependencies:
        <pre><code>composer install --ignore-platform-req=ext-gd</code></pre>
        <pre><code>./vendor/laravel/sail/bin/sail up -d</code></pre>
        <pre><code>sail bash</code></pre>
        <pre><code>composer update</code></pre>
        <pre><code>npm install</code></pre>
        <pre><code>npm run dev</code></pre>
    </li>
    <li>Generate the application key:
        <pre><code>php artisan key:generate</code></pre>
    </li>
    <li>Migrate the database and run seeds:
        <pre><code>php artisan migrate --seed</code></pre>
    </li>
    <li>Run the application:
        Access the application at <code>http://127.0.0.1</code>.</li>
</ul>

<h2>Contributing</h2>
<p>Contributions are welcome! Please open an issue or submit a pull request for any changes you'd like to suggest.</p>

![Screenshot from 2024-10-09 16-59-15](https://github.com/user-attachments/assets/aa9bb7eb-c568-45fb-a2ce-eccfb0b22f6e)
![Screenshot from 2024-10-09 16-58-56](https://github.com/user-attachments/assets/18e2559a-3f17-4998-bc05-d4abf96d8b17)
![Screenshot from 2024-10-09 16-58-50](https://github.com/user-attachments/assets/e1292bc8-ad79-415a-952a-f449bb2fe1d8)
![Screenshot from 2024-10-09 16-57-56](https://github.com/user-attachments/assets/024e0d37-6f76-4952-a737-46405bda5bbb)
![Screenshot from 2024-10-09 16-57-33](https://github.com/user-attachments/assets/cd6777af-eeba-4192-b695-7af19c5b873b)
![Screenshot from 2024-10-09 16-57-25](https://github.com/user-attachments/assets/bdf9a818-8d91-439b-a08c-5d14aee6299a)
![Screenshot from 2024-10-09 16-57-15](https://github.com/user-attachments/assets/e8dc1d7b-2919-478a-9d72-3916e2d72e15)
![Screenshot from 2024-10-09 16-57-07](https://github.com/user-attachments/assets/a6015dc6-0054-4460-835f-b3ecdd950eb9)
![Screenshot from 2024-10-09 16-56-52](https://github.com/user-attachments/assets/b949dfe3-fcff-4190-bd4f-d459d4c35324)
![Screenshot from 2024-10-09 16-56-23](https://github.com/user-attachments/assets/08c381a4-4aa4-47bc-86d1-413456dd0002)
![Screenshot from 2024-10-09 16-56-10](https://github.com/user-attachments/assets/034b03db-bcc9-4356-a689-c34dc599315e)
![Screenshot from 2024-10-09 16-55-52](https://github.com/user-attachments/assets/d42ec8c5-16eb-4889-96e6-d23ce2c670e3)
![Screenshot from 2024-10-09 16-55-28](https://github.com/user-attachments/assets/a11eaeae-2200-4aff-86ae-2c03aa2cef1f)
![Screenshot from 2024-10-09 16-54-04](https://github.com/user-attachments/assets/14243e69-05df-409b-82a6-df255cb46785)
![Screenshot from 2024-10-09 16-53-35](https://github.com/user-attachments/assets/7a345b0e-516a-438a-96e5-e1bdaf7d2f35)
![Screenshot from 2024-10-09 16-53-18](https://github.com/user-attachments/assets/9ba88b18-7188-4936-b4c6-23e4ac04146f)
![Screenshot from 2024-10-09 16-51-56](https://github.com/user-attachments/assets/b477360f-ad1b-4e36-a2e4-209fe168c152)
![Screenshot from 2024-10-09 16-51-48](https://github.com/user-attachments/assets/f2cd9805-4f85-478c-93a6-3af75e41a45d)
![Screenshot from 2024-10-09 16-51-12](https://github.com/user-attachments/assets/7e5986af-72b1-49f4-a956-2ae2fd9fdc5b)
![Screenshot from 2024-10-09 16-50-04](https://github.com/user-attachments/assets/0e6a2de2-36ac-4ae3-9e44-df98e19562a9)
![Screenshot from 2024-10-09 16-49-04](https://github.com/user-attachments/assets/52e3b994-c79f-41c5-b7f5-49a51e4a1ddb)
![Screenshot from 2024-10-09 16-48-27](https://github.com/user-attachments/assets/462abc59-0d49-4eaf-af40-a55fd8c28344)
![Screenshot from 2024-10-09 23-10-30](https://github.com/user-attachments/assets/ef28aa3b-b572-4085-b00b-d402d367a167)



