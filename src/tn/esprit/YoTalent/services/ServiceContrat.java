/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;

import tn.esprit.YoTalent.entities.Contrat;
import tn.esprit.YoTalent.utils.MaConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.entities.Voyage;


/**
 *
 * @author USER
 */
public class ServiceContrat implements IService<Contrat> {
    private Connection cnx;

    public ServiceContrat(){
        cnx = MaConnexion.getInstance().getCnx();
    }

    @Override
    public void createOne(Contrat contrat) throws SQLException {
        
 String req =   "INSERT INTO contrat`( nomC` ,`DateDC`, DateFC,`idVoy`)" + "VALUES ('"+contrat.getNomC()+"', '"+contrat.getDateDC()+"','"+contrat.getDateFC()+"','"+contrat.getIdVoy()+"')";
   
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("contrat ajouté !");
        }
    
    @Override
    public void updateOne(Contrat contrat) throws SQLException {
     
        
 }
    @Override
    
    public void deletOne(Contrat contrat) throws SQLException {
        
    }

  
   
    @Override
    public List<Contrat> selectAll() throws SQLException {
   List<Contrat> temp = new ArrayList<>();

        String req = "SELECT * FROM Contrat";
        PreparedStatement ps = cnx.prepareStatement(req);

        ResultSet rs = ps.executeQuery();

        while (rs.next()){

            Contrat Cat = new Contrat();

            Cat.setIdC(rs.getInt(1));
            
            Cat.setNomC(rs.getString("nomC"));
            Cat.setDateDC(rs.getString("DateDC"));
            Cat.setDateFC(rs.getString("DateFC"));
            // Cat.setIdVoy(rs.getInt(5));
            
           

            temp.add(Cat);

        }


        return temp;
    }  
    }
    
    
    
    