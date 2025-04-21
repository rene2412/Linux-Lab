sold = [2499.0, 29.97, 699.99, 599.0, 99.0, 749.0, 899.0, 11.99, 199.0, 99.0, 19.99, 499.0, 89.0, 249.99, 449.0, 29.99, 649.0, 69.9]

def totalSales(sold):
    result = 0
    for price in sold:
        result += price;
    return round(result, 2)

print(totalSales(sold))

