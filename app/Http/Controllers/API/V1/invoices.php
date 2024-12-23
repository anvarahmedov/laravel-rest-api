invoices
$table->integer('customer_id');
            $table->integer('amount');
            $table->string('status');
            $table->dateTime('billed_date');
            $table->dateTime('paid_date')->nullable();

customers

$table->string('name');
            $table->string('type');
            $table->string('email');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');