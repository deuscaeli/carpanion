SELECT C.name, count(*) 
FROM rides R JOIN customer C ON R.customer_id = C.id 
WHERE R.destination = "O'Hare International Airport (ORD), West O'Hare Avenue, Chicago, IL, USA" or R.destination = "OHARE" 
Group BY C.name;
#//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
SELECT C.name as driver_name, C2.name as rider_name, COUNT(*)
FROM customer C JOIN rides R ON C.id = R.customer_id JOIN bookings B ON B.ride_id = R.id JOIN customer C2 ON C2.id = B.customer_id
GROUP BY driver_name, rider_name