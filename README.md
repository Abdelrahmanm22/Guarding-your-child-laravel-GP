# Footprint Tracking

**Graduation Project (2023-2024)**  
Cairo University - Faculty of Computers and Artificial Intelligence, Department of Computer Sciences

**Supervised by:**  
- Dr. Desoky Abd El-qawy  
- TA. Asmaa  

**Developed by:**  
- Ibrahim Esmail Ebrahim (20200828)  
- Zeyad Farag Mohamed (20200203)  
- Youssef Diaa El Sayed (20200813)  
- Abdelrahman Mohamed Ramadan (20200293)  
- Abdelrahman Tarek Rafaat (20200288)  

---

## Abstract

Footprint Tracking is an innovative project designed to address the global issue of missing and kidnapped children, especially newborns who lack identifiable facial characteristics. Using footprint recognition technology, the software enables hospitals to create a secure database of newborn profiles. If a case of suspected kidnapping arises, law enforcement can search for a child's profile by scanning their footprint or fingerprint, verifying parent information if a match is found.

This tool serves as a resource for both hospitals and child welfare organizations by maintaining a secure database, assisting with parental disputes, adoption cases, and other legal matters where child identification is critical. Through its fingerprint recognition technology, the system provides a robust solution to enhance child protection and aid in the search for missing children.

---

## Table of Contents

1. [Introduction](#introduction)
   - Motivation
   - Problem Definition
   - Problem Objective
2. [Methodology](#methodology)
3. [Used Tools](#used-tools)
4. [Related Work](#related-work)
5. [Model Architecture](#model-architecture)
6. [Dataset](#dataset)
7. [Project Phases](#project-phases)
8. [Conclusion](#conclusion)

---

## Introduction

### Motivation

According to reports by the National Center for Missing and Exploited Children (NCMEC) and the International Centre for Missing & Exploited Children (ICMEC), Egypt is among the top countries in the MENA region for missing children. This project aims to leverage technology to support faster, more accurate searches and reunions of missing children with their families.

### Problem Definition

Traditional search methods for missing children are slow and often ineffective, especially for newborns. This project addresses the challenges of finding missing children by enabling the registration of newborn footprints in a searchable database accessible to law enforcement.

### Problem Objective

Footprint Tracking allows medical professionals to easily record newborn footprints, along with critical information such as names, addresses, and parent details. Law enforcement can identify and track children in abandonment or kidnapping scenarios, supporting child protection efforts and facilitating family reunions.

---

## Methodology

Our methodology follows the **Waterfall** model:
1. **Requirements**: Gathering needs from doctors and law enforcement.
2. **Design**: Developing a structured system to enable footprint uploading, record-keeping, and fingerprint recognition.
3. **Implementation**: Building and integrating the front end with machine learning models for fingerprint recognition.
4. **Testing**: Conducting unit, integration, and usability testing.
5. **Deployment & Maintenance**: Releasing the system for use and ensuring continuous support.

---

## Used Tools

### Front-End
- **Flutter**: Enables cross-platform development for Android, iOS, and web applications.

### Machine Learning
- **Flask**: For deploying machine learning models as web applications.

### Back-End
- **Laravel**: Manages data processing, storage, and API development.

---

## Related Work

Existing tools like **Safe Kids**, **Find My Kids**, and **Social Media Platforms** (e.g., Amber Alerts) have inspired the development of this project. Footprint Tracking leverages these concepts by incorporating footprint/fingerprint recognition, making it accessible even for newborns who lack developed facial characteristics.

---

## Model Architecture

### Siamese Network

Our model uses a **Siamese Network** for one-shot learning, a model architecture ideal for identifying unique features with limited data. This includes:
- **Twin Networks**: Shared weights for comparable feature extraction.
- **Distance Metric**: Measures similarity between inputs, classifying them as similar or dissimilar.

### Advantages
- **Data Efficiency**: Requires fewer samples.
- **Scalability**: Can adapt to new individuals without extensive retraining.

---

## Dataset

Our dataset comprises hundreds of labeled fingerprints and footprints. Images are preprocessed and resized, with augmentations applied to address limited data availability.

---

## Project Phases

1. **Requirements Gathering**
2. **Design and Architecture**
3. **Implementation (ML model, Front-End, Back-End)**
4. **Testing**
5. **Deployment & Maintenance**

---

## Conclusion

The Footprint Tracking system represents an important step in child protection, enabling faster, accurate identification of missing, kidnapped, or abandoned children. Through this project, we aim to empower law enforcement and medical professionals with the tools needed to support child safety and reunification efforts.

--- 
