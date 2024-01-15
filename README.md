## Token Bucket Algorithm

A token bucket is a simple algorithm to control the rate at which events occur. It is often employed in scenarios where a system needs to limit the number of occurrences of an event within a specified time period. The token bucket algorithm is used for traffic shaping and rate limiting, ensuring that a system does not exceed a certain rate of event occurrences.

### Algorithm Overview

1. **Bucket:** Imagine a bucket that holds tokens. Tokens are the units that represent permission to perform a certain action.

2. **Rate:** The bucket has a refill rate, specifying how quickly new tokens are added to the bucket over time.

3. **Capacity:** The bucket also has a maximum capacity, defining the maximum number of tokens it can hold.

4. **Usage:** When an event occurs, the system checks if there is at least one token available in the bucket. If there is, the event is allowed, and one token is consumed. If there are no tokens, the event is either delayed until a token becomes available or is rejected, depending on the application.

5. **Refill:** The bucket refills at a constant rate, adding new tokens to it. If the bucket is full, new tokens are discarded.

### Use Cases

The token bucket algorithm provides a way to control the rate of events by regulating the flow of tokens into the bucket. It is particularly useful for scenarios like limiting the rate of requests to a web server, preventing a system from being overwhelmed by a burst of traffic.

Token buckets are often used in combination with other algorithms and techniques to achieve effective traffic management and ensure fairness in resource allocation.
