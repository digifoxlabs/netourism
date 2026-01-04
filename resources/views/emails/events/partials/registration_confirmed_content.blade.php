<div class="space-y-6 text-sm text-slate-800">

    <h1 class="text-xl font-semibold text-slate-900">
        Registration Confirmed
    </h1>

    <p>Dear <strong>{{ $registration->full_name }}</strong>,</p>

    <p>
        Congratulations! Your registration for 
        <strong>{{ $registration->event_name }}</strong> 
        has been successfully confirmed.
    </p>

    <p>
        We are excited to have you join <strong>The Hind Riders</strong> and 
        <strong>NeTourism</strong> for this adventure!
    </p>

    <!-- Event Summary -->
    <h2 class="text-lg font-semibold mt-6">Event Summary</h2>

    <table class="w-full border border-slate-200 text-sm">
        <tbody>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium w-1/3 bg-slate-50">Event Dates</td>
                <td class="px-3 py-2">20th December (Sat) – 21st December (Sun), 2025</td>
            </tr>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium bg-slate-50">Destination</td>
                <td class="px-3 py-2">Bon Birina Eco Camp & Farm, Kaziranga</td>
            </tr>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium bg-slate-50">Registration Fee</td>
                <td class="px-3 py-2">₹2,299/- (Received)</td>
            </tr>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium bg-slate-50">Confirmation Number</td>
                <td class="px-3 py-2">{{ $registration->transaction_id }}</td>
            </tr>
            <tr>
                <td class="px-3 py-2 font-medium bg-slate-50">Participant ID</td>
                <td class="px-3 py-2">#{{ $registration->id }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Instructions & Schedule -->
    <h2 class="text-lg font-semibold mt-6">Key Instructions & Schedule</h2>

    <table class="w-full border border-slate-200 text-sm">
        <tbody>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium w-1/3 bg-slate-50">Assembly Point</td>
                <td class="px-3 py-2">TAJ Hotel, Khanapara</td>
            </tr>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium bg-slate-50">Assembly Time</td>
                <td class="px-3 py-2">08:00 AM Sharp on Saturday, 20th December 2025</td>
            </tr>
            <tr class="border-b">
                <td class="px-3 py-2 font-medium bg-slate-50">Activities Included</td>
                <td class="px-3 py-2">
                    Motorcycle Ride, Jungle Camping, Bonfires, Dinner, Breakfast, Wildlife Jeep Safari
                </td>
            </tr>
            <tr>
                <td class="px-3 py-2 font-medium bg-slate-50">What to Carry</td>
                <td class="px-3 py-2">
                    Warm clothes, personal medication, water bottle, riding gear (if riding)
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Contacts -->
    <h2 class="text-lg font-semibold mt-6">Important Contacts</h2>

    <ul class="list-disc ml-6 text-sm space-y-1">
        <li>Hind Riders: <strong>+91-93658-04680</strong></li>
        <li>Website: <strong>www.netourism.com</strong></li>
    </ul>

    <p class="mt-6">
        We look forward to riding with you and sharing the wild experience of Kaziranga!
    </p>

    <p class="font-semibold">
        Best Regards,<br>
        The Hind Riders Motorcycle Community & NeTourism Team
    </p>

</div>
