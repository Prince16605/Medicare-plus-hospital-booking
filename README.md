# 🏥 MediCare Plus – Hospital Appointment Booking System


MediCare Plus is a web-based hospital appointment booking system deployed on AWS. Patients can view doctors and book appointments online. Appointment data is stored in Amazon RDS MySQL and images are stored in Amazon S3.

## ✨ Features

- Doctor listing and specialization
- Doctor availability
- Online appointment booking
- Appointment date and time selection
- Patient information
- Appointment confirmation
- MySQL database integration
- AWS cloud deployment

## 🏗️ AWS Architecture

```text
                         ┌───────────────────┐
                         │   Patients / Users│
                         └─────────┬─────────┘
                                   │
                                   ▼
                              ┌───────────┐
                              │ Internet  │
                              └─────┬─────┘
                                    │
                                    ▼
                          ┌──────────────────┐
                          │ Internet Gateway │
                          │      (IGW)       │
                          └────────┬─────────┘
                                   │
                                   ▼
              ┌───────────────────────────────────────┐
              │                AWS VPC                 │
              │              10.0.0.0/16               │
              │                                       │
              │  ┌─────────────────────────────────┐  │
              │  │          Public Subnet          │  │
              │  │           10.0.1.0/24           │  │
              │  │                                 │  │
              │  │  ┌───────────────────────────┐  │  │
              │  │  │ Application Load Balancer │  │  │
              │  │  └─────────────┬─────────────┘  │  │
              │  │                │                │  │
              │  │        ┌───────▼───────┐        │  │
              │  │        │  NAT Gateway  │        │  │
              │  │        └───────────────┘        │  │
              │  └─────────────────────────────────┘  │
              │                  │                    │
              │                  ▼                    │
              │  ┌─────────────────────────────────┐  │
              │  │       Private App Subnet        │  │
              │  │           10.0.2.0/24           │  │
              │  │                                 │  │
              │  │   ┌─────┐ ┌─────┐ ┌─────┐       │  │
              │  │   │ EC2 │ │ EC2 │ │ EC2 │       │  │
              │  │   │  01 │ │  02 │ │  03 │       │  │
              │  │   └─────┘ └─────┘ └─────┘       │  │
              │  │        Auto Scaling Group        │  │
              │  └─────────────────────────────────┘  │
              │                  │                    │
              │                  ▼                    │
              │  ┌─────────────────────────────────┐  │
              │  │        Private DB Subnet        │  │
              │  │           10.0.3.0/24           │  │
              │  │                                 │  │
              │  │       ┌─────────────────┐       │  │
              │  │       │ Amazon RDS      │       │  │
              │  │       │     MySQL       │       │  │
              │  │       └─────────────────┘       │  │
              │  └─────────────────────────────────┘  │
              └───────────────────────────────────────┘

                    ┌────────────────────┐
                    │     Amazon S3      │
                    │ Doctor / Hospital  │
                    │      Images        │
                    └────────────────────┘

                    ┌────────────────────┐
                    │   CloudWatch       │
                    │ Monitoring & Alarms│
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │       SNS          │
                    │   Notifications    │
                    └────────────────────┘
```

## ☁️ AWS Services

| Service | Purpose |
|---|---|
| Amazon VPC | Isolated cloud network |
| 3 Subnets | Public, App and Database |
| 2 Route Tables | Public and Private traffic routing |
| Internet Gateway | Internet connectivity |
| NAT Gateway | Outbound internet for private resources |
| EC2 | Hosts the application |
| Application Load Balancer | Distributes traffic |
| Auto Scaling | Scales EC2 instances |
| Amazon S3 | Stores doctor and hospital images |
| Amazon RDS MySQL | Stores appointment data |
| CloudWatch | Monitoring and alarms |
| SNS | Sends notifications |

## 🔄 Application Flow

```text
Patient
   ↓
Internet
   ↓
Internet Gateway
   ↓
Application Load Balancer
   ↓
EC2 Instances
   ↓
PHP Application
   ↓
Amazon RDS MySQL
```

Images are stored separately in **Amazon S3**.

## 🔐 Security

- Public and private subnet separation
- Application servers placed in private subnet
- Database placed in private subnet
- Security Groups control access
- NAT Gateway provides outbound access for private resources
- RDS is not directly exposed to the internet

## 📈 Scalability & Monitoring

The Application Load Balancer distributes traffic across EC2 instances, while Auto Scaling helps maintain the required number of application servers.

CloudWatch monitors AWS resources and can trigger alarms. SNS sends notifications when configured alarms are triggered.

## 🛠️ Technology Stack

- HTML5
- CSS3
- JavaScript
- PHP
- Nginx
- MySQL
- AWS

## 👨‍💻 Author

**Prince vaghasiya**

## ⭐ Project Summary

This project demonstrates a real-world hospital appointment application deployed on AWS using networking, compute, database, storage, load balancing, auto scaling, monitoring, and notification services.
