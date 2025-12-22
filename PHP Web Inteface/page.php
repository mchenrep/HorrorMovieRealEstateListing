<!DOCTYPE html>
<html>
<head>
    <title>Horror Listings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-btn" data-target="houses">Houses</button>
        <button class="tab-btn" data-target="business">Business Properties</button>
        <button class="tab-btn" data-target="buyers">Buyers</button>
        <button class="tab-btn" data-target="agents">Agents</button>
        <button class="tab-btn" data-target="customQuerySection">Custom Query</button>
    </div>
    <!-- Tab Content -->
        <!-- Houses -->
    <div id="houses" class="tab-content">
        <div class="filters">
            <input type="number" id="minPriceHouse" placeholder="Min Price">
            <input type="number" id="maxPriceHouse" placeholder="Max Price">
            <input type="number" id="bedroomsHouse" placeholder="Bedrooms">
            <input type="number" id="bathroomsHouse" placeholder="Bathrooms">
            <button onclick="loadHouses()">Apply Filters</button>
        </div>
        <div id="houseResults"></div>
    </div>
        <!-- Business Properties -->
    <div id="business" class="tab-content">
        <div class="filters">
            <input type="number" id="minPriceBusiness" placeholder="Min Price">
            <input type="number" id="maxPriceBusiness" placeholder="Max Price">
            <input type="text" id="typeBusiness" placeholder="Business Type">
            <input type="number" id="minSizeBusiness" placeholder="Min Size">
            <input type="number" id="maxSizeBusiness" placeholder="Max Size">
            <button onclick="loadBusiness()">Apply Filters</button>
        </div>
        <div id="businessResults"></div>
    </div>
        <!-- Buyers -->
    <div id="buyers" class="tab-content">
        <div id="buyersResults"></div>
    </div>
        <!-- Agents -->
    <div id="agents" class="tab-content">
        <div id="agentsResults"></div>
    </div>
        <!-- Custom Queries -->
    <div id="customQuerySection" class="tab-content">
        <h3>Custom SQL Query</h3>
        <textarea id="sqlQuery" rows="4" cols="80" placeholder="Type your SQL query here..."></textarea><br>
        <button onclick="loadQuery()">Run Query</button>
        <div id="queryResults"></div>
    </div>

    <!-- JavaScript Implementation -->
    <script>
        // Tab Implementation
        const buttons = document.querySelectorAll(".tab-btn");
        const contents = document.querySelectorAll(".tab-content");
        
        contents.forEach(c => c.style.display = "none"); // hide other tabs
        document.getElementById("houses").style.display = "block"; // default tab

        window.addEventListener("DOMContentLoaded", () => { // auto load all tabs (default arguments)
            loadHouses();
            loadBusiness();
            loadBuyers();
            loadAgents();
        });

        buttons.forEach(btn => {
            btn.addEventListener("click", () => {
                contents.forEach(c => c.style.display = "none");
                const id = btn.dataset.target;
                document.getElementById(id).style.display = "block";
            });
        });
        
        // Houses Implementation
        function loadHouses() {    
            const minPrice = document.getElementById("minPriceHouse").value;
            const maxPrice = document.getElementById("maxPriceHouse").value;
            const bedrooms = document.getElementById("bedroomsHouse").value;
            const bathrooms = document.getElementById("bathroomsHouse").value;

            const url = encodeURI(`/Website Project COP4710/houses.php?minPrice=${minPrice}&maxPrice=${maxPrice}&bedrooms=${bedrooms}&bathrooms=${bathrooms}`);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("houseResults");
                    container.innerHTML = "";
                    data.forEach(h => {
                        container.innerHTML += `
                            <div class="listing">
                                <h3>${h.address}</h3>
                                <p>Owner: ${h.ownerName}</p>
                                <p>Price: $${h.price}</p>
                                <p>${h.bedrooms} beds, ${h.bathrooms} baths</p>
                                <p>Agent: ${h.agentName}</p>
                                <small>Date Listed: ${h.dateListed}</small>
                            </div>
                        `;
                    });
                });
        }

        // Business Properties Implementation
        function loadBusiness() {    
            const minPrice = document.getElementById("minPriceBusiness").value;
            const maxPrice = document.getElementById("maxPriceBusiness").value;
            const type = document.getElementById("typeBusiness").value;
            const minSize = document.getElementById("minSizeBusiness").value;
            const maxSize = document.getElementById("maxSizeBusiness").value;

            const url = `/Website Project COP4710/business.php?` +
            `minPrice=${encodeURIComponent(minPrice)}` +
            `&maxPrice=${encodeURIComponent(maxPrice)}` +
            `&type=${encodeURIComponent(type)}` +
            `&minSize=${encodeURIComponent(minSize)}` +
            `&maxSize=${encodeURIComponent(maxSize)}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("businessResults");
                    container.innerHTML = "";

                    data.forEach(b => {
                        container.innerHTML += `
                            <div class="listing">
                                <h3>${b.address}</h3>
                                <p>Owner: ${b.ownerName}</p>
                                <p>Type: ${b.type}</p>
                                <p>Size: ${b.size} sq ft</p>
                                <p>Price: $${b.price}</p>
                                <p>Agent: ${b.agentName}</p>
                                <small>Date Listed: ${b.dateListed}</small>
                            </div>
                        `;
                    });
                });
        }

        // Buyers Implementation
        function loadBuyers() {
            fetch('/Website Project COP4710/buyers.php')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("buyersResults");
                    container.innerHTML = "";
                    data.forEach(b => {
                        container.innerHTML += `
                            <div class="listing">
                                <h3>${b.name}</h3>
                                <p>${b.phone}</p>
                                <p>Looking for: ${b.propertyType}</p>
                        `;
                        if (b.propertyType === "Business Property") {
                            container.innerHTML += `<p>Property Type: ${b.businessPropertyType}</p>`;
                        }
                        else if(b.propertyType === "House"){
                            container.innerHTML += `<p>Bedrooms: ${b.bedrooms} Bathrooms: ${b.bathrooms}</p>`;
                        }
                            container.innerHTML += `<p>Price Range: $${b.minimumPreferredPrice} - $${b.maximumPreferredPrice}</p></div>`;
                    });
                });
        }

        // Agent Implementation
        function loadAgents() {
            const firms = { // join firmId with firm name
                1: "Horror Realty",
                2: "Nightmare Estates",
                3: "Woodsboro Estates",
                4: "Nostromo Realty",
                5: "Crystal Lake Realty"
            };

            fetch('/Website Project COP4710/agents.php')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("agentsResults");
                    container.innerHTML = "";
                    data.forEach(b => {
                        const firmName = firms[b.firmId] || "N/A";
                        container.innerHTML += `
                            <div class="listing">
                                <h3>${b.name}</h3>
                                <p>${b.phone}</p>
                                <p>Firm: ${firms[b.firmId]}</p>
                                <p>Date Started: ${b.dateStarted}</p>
                            </div>
                        `;
                    });
                });
        }

        // Custom Query Implementation
        function loadQuery(){
            const query = document.getElementById("sqlQuery").value;

            fetch('/Website Project COP4710/customquery.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ sql: query })
            })
            .then(res => res.json()
                .catch(() => ({ error: `Invalid JSON response from server (HTTP ${res.status})` }))
            )
            .then(data => {
                const container = document.getElementById("queryResults");
                container.innerHTML = "";   
                if (data.error) {
                    container.innerHTML = `<p style="color:red;">Error: ${data.error}</p>`; 
                    return;
                }
                if (data.length > 0) {
                    let html = "<table border='1'><tr>";
                    Object.keys(data[0]).forEach(col => html += `<th>${col}</th>`);
                    html += "</tr>";
                    data.forEach(row => {
                        html += "<tr>";
                        Object.values(row).forEach(val => html += `<td>${val}</td>`);
                        html += "</tr>";
                    });
                    html += "</table>";
                    container.innerHTML = html;
                } else {
                    container.innerHTML = "<p>No results</p>";
                }    
            })
            .catch(err => {
                const container = document.getElementById("queryResults");
                container.innerHTML = `<p style="color:red;">Network or server error: ${err.message}</p>`;
            });
        }

    </script>

</body>
</html>