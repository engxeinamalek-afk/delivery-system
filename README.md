# Delivery System

Simple Laravel Delivery System built to manage orders and deliveries easily. The project includes a secure login system with three different roles:

*   **Admin Dashboard:**
    *   **Store Management:** Seamlessly add new stores and manage their activation status (Enable/Disable).
    *   **Live Order Monitoring:** Keep track of daily orders, delayed shipments, and specific driver logs.
    *   **Smart Dispatch System:** Manually assign drivers to urgent orders based on real-time availability and the longest waiting time metric.

*   **Customer Features:**
    *   **Store Exploration:** Browse all available and active stores within the platform.
    *   **Order Placement:** Create and submit delivery orders effortlessly.

*   **Driver Features:**
    *   **Assigned Orders:** View all orders assigned directly to them.
    *   **Status Management:** Update the real-time order lifecycle status to either `picked_up` or `delivered`.

## Architecture: Contextual Binding

The system uses **Laravel's Contextual Binding** to handle driver assignments.The application automatically switches between two strategies implementing the same interface:

* **Automated Assignment:** 
  Triggered automatically when a customer creates an order. It assigns the driver with the `fewest orders today` to balance the workload fairly.

* **Manual Assignment (by admin):** 
  Triggered manually from the admin panel. It selects the `available` driver with the `longest idle time` since their last delivered order.

## Data Filtering: Global Scope

The system uses a `Global Scope` to control store visibility:

* **Customers:** Inactive stores are automatically hidden from their view.
* **Admins:** Can see all stores (including disabled ones) using `withoutGlobalScope`.

## Local Scopes:
Used across models to wrap common query filters, preventing code duplication.
## No Lazy Loading: 
Disallowed globally to prevent the **N+1 query problem**. Instead, **Eager Loading** (`with`) is utilized to fetch relationships efficiently in a single query, drastically reducing database load.

## Database Optimization: Indexing Strategy

A composite index was implemented on the `orders` table combining: `driver_id`, `assigned_at`, and `status`.

### Why this index?
This specific composite index speeds up the three most frequent daily database queries in the system:

* **Automated Dispatching:** Fast-tracks checking and filtering orders by `driver_id` and `assigned_at` to calculate driver workloads.
* **Driver Order Feeds:** Optimizes the driver's query when fetching their own assigned orders filtered by `driver_id`, `assigned_at`, and delivery `status`.
* **Admin Monitoring:** Accelerates dashboard queries when the admin reviews a specific driver's trip history filtered by `driver_id` and `assigned_at`.



## API Endpoints Documentations

All routes are protected by **Sanctum Authentication** and restricted to specific user roles.

### Admin Endpoints (`/admin`)

* **`POST /admin/stores`** - Add a new merchant store.
    `body:` 
```
{"name": "zeze store"}
```
* **`GET /admin/stores`** - Fetch all stores (including disabled ones).
    `body: null`
* **`PATCH /admin/stores/{store}/status`** - Toggle store activation status (Enable/Disable).
    `body:`
```
{"is_active": true}
```
* **`GET /admin/driver/{driver}/orders`** - Retrieve today orders assigned to a specific driver.
    `body: null`
* **`GET /admin/orders/delayed`** - Fetch all delayed orders.
    `body: null`
* **`GET /admin/orders/today`** - Monitor today's orders.
    `body: null`
* **`PATCH /admin/orders/{order}/driver`** - Manually assign a driver to an urgent order.
    `body: null`

### Customer Endpoints (`/customer`)

* **`GET /customer/stores`** - Browse active available stores only.
    `body: null`
* **`POST /customer/orders`** - Create a new delivery order.
    `body:` 
```
{"store_id":1
    items:[{
        "item_name": "Matte Liquid Lipstick",
        "details": "Shade 04 - Classic Red"
    },{
        "item_name": "Full Coverage Foundation",
        "details": "Volume: 30ml, Skin Tone: Ivory"
    }]}
```

### Driver Endpoints (`/driver`)

* **`GET /driver/orders`** - View today orders assigned to the logged-in driver.
    `body: null`
* **`PATCH /driver/orders/{order}/take`** - Update order status to `pick_up`.
    `body: null`
* **`PATCH /driver/orders/{order}/deliver`** - Update order status to `delivered`.
    `body: null`

