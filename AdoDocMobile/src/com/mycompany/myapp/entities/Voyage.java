/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;
import java.util.Date;
/**
 *
 * @author ASMA
 */
public class Voyage {
    private int idVoy;
    private String dateDvoy,dateRvoy,destination;
    private int idC;

    public Voyage(String dateDvoy, String dateRvoy, String destination, int idC) {
        this.dateDvoy = dateDvoy;
        this.dateRvoy = dateRvoy;
        this.destination = destination;
        this.idC = idC;
    }

    
    
    public Voyage(String destination) {
        this.destination = destination;
    }

    public Voyage() {
    }

    public Voyage(int idVoy, String dateDvoy, String dateRvoy, String destination, int idC) {
        this.idVoy = idVoy;
        this.dateDvoy = dateDvoy;
        this.dateRvoy = dateRvoy;
        this.destination = destination;
        this.idC = idC;
    }

    public Voyage(String dateDvoy, String dateRvoy, String destination) {
        this.dateDvoy = dateDvoy;
        this.dateRvoy = dateRvoy;
        this.destination = destination;
    }

    public int getIdVoy() {
        return idVoy;
    }

    public String getDateDvoy() {
        return dateDvoy;
    }

    public String getDateRvoy() {
        return dateRvoy;
    }

    public String getDestination() {
        return destination;
    }

    public int getIdC() {
        return idC;
    }

    public void setIdVoy(int idVoy) {
        this.idVoy = idVoy;
    }

    public void setDateDvoy(String dateDvoy) {
        this.dateDvoy = dateDvoy;
    }

    public void setDateRvoy(String dateRvoy) {
        this.dateRvoy = dateRvoy;
    }

    public void setDestination(String destination) {
        this.destination = destination;
    }

    public void setIdC(int idC) {
        this.idC = idC;
    }

    @Override
    public String toString() {
        return "Voyage{" + "idVoy=" + idVoy + ", dateDvoy=" + dateDvoy + ", dateRvoy=" + dateRvoy + ", destination=" + destination + ", idC=" + idC + '}';
    }
    
    
}
