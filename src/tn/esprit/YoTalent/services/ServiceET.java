/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.services;


import tn.esprit.YoTalent.entities.EspaceTalent;

import tn.esprit.YoTalent.utils.MaConnexion;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.sql.PreparedStatement;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.entities.Contrat;
import tn.esprit.YoTalent.entities.User;
import tn.esprit.YoTalent.entities.Video;



/**
 *
 * @author USER
 */
public class ServiceET implements IService<EspaceTalent> {
    private Connection cnx;
  ServiceVideo sv = new ServiceVideo();
            ServiceCategorie sc = new ServiceCategorie();
             ServiceContrat c = new ServiceContrat();
    public ServiceET(){
        cnx = MaConnexion.getInstance().getCnx();
    }

    @Override
    public void createOne(EspaceTalent espacetalent) throws SQLException {
      String req =   "INSERT INTO espacetalent (titre, idU, idVid, idCat, idC) VALUES ('" + espacetalent.getTitre() + "', '" + espacetalent.getIdU().getIdU() + "', '" + espacetalent.getIdVid().getIdVid() + "', '" + espacetalent.getIdCat().getIdCat() + "', '" + espacetalent.getIdC().getIdC() + "')";
        Statement st = cnx.createStatement();
        st.executeUpdate(req);
        System.out.println("espacetalent ajouté !");
      
    }
    

    @Override
    public void updateOne(EspaceTalent espacetalent) throws SQLException {
   String req = "UPDATE espacetalent SET `idEST`=?,`titre`=?, `idU`=?, `idVid`=? , `idCat`=? , `idC`=?  WHERE idEST=" + espacetalent.getIdEST();


       
            PreparedStatement pst =cnx.prepareStatement(req);

            pst.setInt(1, espacetalent.getIdEST());
            pst.setString(2, espacetalent.getTitre());
             pst.setInt(3, espacetalent.getIdU().getIdU());
              pst.setInt(4, espacetalent.getIdVid().getIdVid());
               pst.setInt(5, espacetalent.getIdCat().getIdCat());
                pst.setInt(6, espacetalent.getIdC().getIdC());
           
            pst.executeUpdate();
            System.out.println("espacetalent " + espacetalent.getTitre() + " is updated successfully");
    }

    @Override
    public void deletOne(EspaceTalent espacetalent) throws SQLException {
try {
            String req = "DELETE FROM espacetalent WHERE espacetalent.`idEST` = ?";
            PreparedStatement ste = cnx.prepareStatement(req);
            ste.setInt(1, espacetalent.getIdEST());
            ste.executeUpdate();
            System.out.println("espace talent  supprimé");

        } catch (SQLException ex) {
            Logger.getLogger(ServiceET.class.getName()).log(Level.SEVERE, null, ex);
        }    }

    
    private User getUserById(int idU) throws SQLException {
    String req = "SELECT * FROM user WHERE idU = ?";
    PreparedStatement ps = cnx.prepareStatement(req);
    ps.setInt(1, idU);
    ResultSet rs = ps.executeQuery();
    if (rs.next()) {
        int id = rs.getInt("idU");
        String nomU = rs.getString("nomU");
       
        String email = rs.getString("email");
        // Créer un nouvel objet User avec les données récupérées
        User user = new User(id,nomU ,email);
        return user;
    }
    return null;
}
public List<Integer> affichagecombo()  {
               List<Integer> arr=new ArrayList<>();
        try {
            
            
            
            PreparedStatement pt = cnx.prepareStatement("select idEST from espacetalent");
            ResultSet rs = pt.executeQuery();
            while (rs.next()) {
                int nom=rs.getInt("idEST");
                
                arr.add(nom);
            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceET.class.getName()).log(Level.SEVERE, null, ex);
        }
        return arr;
    }

    @Override
    public List<EspaceTalent> selectAll() throws SQLException {
          List<EspaceTalent> espacetalents = new ArrayList<>();
    String req = "SELECT * FROM espacetalent";
    Statement st = cnx.createStatement();
    ResultSet rs = st.executeQuery(req);
    while (rs.next()) {
        EspaceTalent espacetalent = new EspaceTalent();
        espacetalent.setIdEST(rs.getInt("idEST"));
        espacetalent.setTitre(rs.getString("titre"));
       User user = new User();
      user.setIdU(rs.getInt("idU"));
      espacetalent.setIdU(user);
      
      
       Video video = new Video();
      video.setIdVid(rs.getInt("idVid"));
      espacetalent.setIdVid(video);
      
      
       Categorie categorie = new Categorie();
      categorie.setIdCat(rs.getInt("idCat"));
      espacetalent.setIdCat(categorie);
      
       Contrat contrat = new Contrat();
      contrat.setIdC(rs.getInt("idC"));
      espacetalent.setIdC(contrat);
      
       
        espacetalents.add(espacetalent);
    }
    return espacetalents;




}
    
    
    public ObservableList<EspaceTalent> FetchEST() throws SQLException {
    ObservableList<EspaceTalent> espaceTalents = FXCollections.observableArrayList();
    String req = "SELECT * FROM espacetalent";
    PreparedStatement pst = cnx.prepareStatement(req);
    ResultSet rs = pst.executeQuery();
    while (rs.next()) {
        EspaceTalent espacetalent = new EspaceTalent();
        espacetalent.setIdEST(rs.getInt("idEST"));
        espacetalent.setTitre(rs.getString("titre"));
        espacetalent.setIdU(new User(rs.getInt("idU"))); // on crée un objet User avec l'identifiant correspondant
        espacetalent.setIdVid(sv.selectOne(rs.getInt("idVid"))); // on récupère l'objet Video correspondant
        espacetalent.setIdCat(sc.selectOne(rs.getInt("idCat"))); // on récupère l'objet Categorie correspondant
        espacetalent.setIdC(c.selectOne(rs.getInt("idC"))); // on récupère l'objet Contrat correspondant
        espaceTalents.add(espacetalent);
    }
    return espaceTalents;
}
    
    
    public ObservableList<EspaceTalent> searchByEST(String titre) throws SQLException{
        String qry="SELECT * FROM espacetalent where titre LIKE '%"+titre+"%'" ;
                  System.out.println(qry);
           
            Statement stm = cnx.createStatement();
            ResultSet rs = stm.executeQuery(qry);
              
        ObservableList<EspaceTalent>  list = FXCollections.observableArrayList()  ; 
        while(rs.next()){
        EspaceTalent espacetalent = new EspaceTalent(rs.getString(2)); 
        User user = new User();
      user.setIdU(rs.getInt("idU"));
      espacetalent.setIdU(user);
      
      
       Video video = new Video();
      video.setIdVid(rs.getInt("idVid"));
      espacetalent.setIdVid(video);
      
      
       Categorie categorie = new Categorie();
      categorie.setIdCat(rs.getInt("idCat"));
      espacetalent.setIdCat(categorie);
      
       Contrat contrat = new Contrat();
      contrat.setIdC(rs.getInt("idC"));
      espacetalent.setIdC(contrat);
      
   
        list.add(espacetalent) ;
        
        }
         

        return list ;
    }
    
    public ObservableList<EspaceTalent> getAllTriTitre() {
        ObservableList<EspaceTalent> list = FXCollections.observableArrayList();
        try {
         //   String req = "Select * from espacetalent where roles like '%[]%' order by nom";
                String req = "Select * from espacetalent  order by titre";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);

            while (rs.next()) {
            //    EspaceTalent u = new EspaceTalent(rs.getInt("id"), rs.getString("nom"), rs.getString("prenom"), rs.getString("username"), rs.getString("email"), rs.getString("file"), rs.getInt("etat"), rs.getDate("created_at"));
               EspaceTalent espacetalent = new EspaceTalent(rs.getString(2)); 
        User user = new User();
      user.setIdU(rs.getInt("idU"));
      espacetalent.setIdU(user);
      
      
       Video video = new Video();
      video.setIdVid(rs.getInt("idVid"));
      espacetalent.setIdVid(video);
      
      
       Categorie categorie = new Categorie();
      categorie.setIdCat(rs.getInt("idCat"));
      espacetalent.setIdCat(categorie);
      
       Contrat contrat = new Contrat();
      contrat.setIdC(rs.getInt("idC"));
      espacetalent.setIdC(contrat);
      
   
        list.add(espacetalent) ;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

        return list;
    }
    }
    
    
    

    

    

