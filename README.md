# First step

Build docker containers

```bash
make build
```

# Second step

Get in container

```bash
make in-php
```

# Third step

While in the container, run:

```bash
symfony console fruits:fetch --env=dev -vvv
```
